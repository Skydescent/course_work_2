<?php

namespace App\Helpers;

use App\Config;

class Uploader
{

    use SaveErrors;

    /**
     * Тип загружаемого файла
     *
     * @var array
     */
    protected $fileType;

    /**
     * Максимальный размер файла
     *
     * @var
     */
    protected $maxFileSize;

    /**
     * Сам файл
     *
     * @var
     */
    protected $file;

    /**
     * Префикс для имени файла
     *
     * @var string
     */
    protected $prefixName;

    /**
     * Путь для загрузки файла в директорию
     *
     * @var
     */
    protected $uploadPath;

    /**
     * Полный путь к файлу с именем файла, возвращаемый после загрузки
     *
     * @var null|string
     */
    protected $filePath = null;

    /**
     * Имя поля загрузки файла для последующего отображения ошибок
     *
     * @var
     */
    protected $fieldName;

    /**
     * Uploader constructor.
     *
     * @param $file
     * @param $fieldName
     * @param $fileType
     * @param $prefixName
     */
    public function __construct($file, $fieldName, $fileType, $prefixName)
    {
        $this->prefixName = is_null($prefixName) ? '' : $prefixName . '_';
        $this->file = $file;
        $this->fieldName = $fieldName;
        $this->initialize($fileType);
    }

    /**
     * Инициализирует тип файла, путь для загрузки и максимальный размер из Config
     *
     * @param $fileType
     */
    public function initialize($fileType)
    {
        $config = Config::getInstance();
        $this->fileType = $config->get('file.fileType.' . $fileType);
        $this->uploadPath = $config->get('file.filePath.' . $fileType);
        $this->maxFileSize = $config->get('file.maxSize.default');
    }


    /**
     * Проверяет ошибки файла, максимальный рзамер, тип файла и загружает
     *
     * @return bool
     */
    public function upload()
    {
        if ( $this->checkFileErrors() &&
            $this->checkFileSize() &&
            $this->checkFileType() &&
            $this->checkUpload()
        ) {
            return true;
        }
        return false;
    }

    /**
     * Удаляет файл
     *
     * @param $file
     */
    public function delete($file)
    {
        unlink($file);
    }

    /**
     * Загружает файл и возвращает true в случае успеха, false в случае неудачи
     *
     * @return bool
     */
    protected function checkUpload()
    {
        $filePath = $this->uploadPath . $this->prefixName . $this->file['name'];
        if (
            move_uploaded_file(
                 $this->file['tmp_name'],
                ROOT . $filePath
            )
        ) {
            $this->filePath = $filePath;
            return true;
        }
        $this->addErrors([$this->fieldName => ['Не удалось загрузить файл, попробуйте ещё раз']]);
        return false;
    }

    /**
     * Возвращает полный путь к загруженному файлу
     *
     * @return null
     */
    public function getUploadedFilePath()
    {
        return $this->filePath;
    }

    /**
     * Проверяет тип файла
     *
     * @return bool
     */
    protected function checkFileType()
    {
        if (array_search(mime_content_type($this->file['tmp_name']), $this->fileType) === false) {
            $this->addErrors(
                [$this->fieldName => ['Файл не соответствует необходимому типу']]
            );
            return false;
        }
        return true;
    }

    /**
     * Проверяет ошибки файла
     *
     * @return bool
     */
    protected function checkFileErrors()
    {
        if ($this->file['error'] !== 0) {
            $this->addErrors([$this->fieldName => ['Ошибка загрузки файла']]);
            return false;
        }
        return true;
    }

    /**
     * Проверяет размер файла
     *
     * @return bool
     */
    protected function checkFileSize()
    {
        if ($this->file['size'] > $this->maxFileSize) {
            $this->addErrors([$this->fieldName => ["Размер файла превышает максимально возможный"]]);
            return false;
        }
        return true;
    }
}
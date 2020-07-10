<?php


namespace App\Helpers;


class Uploader
{

    use SaveErrors;

    protected $fileTypes = [];
    protected $maxFileSize;
    protected $file;
    protected $name;
    protected $uploadPath;
    protected $filePath = null;
    protected $fieldName;

    public function __construct($file, $fieldName, $fileTypes, $name = null)
    {
        $this->name = is_null($name) ? '' : $name . '_';
        $this->file = $file;
        $this->fieldName = $fieldName;
        $this->initialize($fileTypes);
    }

    public function initialize($fileTypes)
    {
        $config = \App\Config::getInstance();
        $this->fileTypes = $config->get('file.fileTypes.' . $fileTypes);
        $this->uploadPath = $config->get('file.filePath.' . $fileTypes);
        $this->maxFileSize = $config->get('file.maxSize');
    }


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

    public function delete($file)
    {
        unlink($file);
    }

    protected function checkUpload()
    {
        if (
            move_uploaded_file(
                $this->name . $this->file['tmp_name'],
                ROOT . $this->uploadPath . $this->file['name']
            )
        ) {
            $this->filePath = $this->uploadPath . $this->file['name'];
            return true;
        }
        $this->addErrors([$this->fieldName => ['Не удалось загрузить файл, попробуйте ещё раз']]);
        return false;
    }

    public function getUploadedFilePath()
    {
        return $this->filePath;
    }

    protected function checkFileType()
    {
        if (array_search(mime_content_type($this->file['tmp_name']), $this->fileTypes) === false) {
            $this->addErrors(
                [$this->fieldName => ['Файл не соответствует необходимому типу']]
            );
            return false;
        }
        return true;
    }

    protected function checkFileErrors()
    {
        if ($this->file['error'] !== 0) {
            $this->addErrors([$this->fieldName => ['Ошибка загрузки файла']]);
            return false;
        }
        return true;
    }

    protected function checkFileSize()
    {
        if ($this->file['size'] > $this->maxFileSize) {
            $this->addErrors([$this->fieldName => ["Размер файла превышает максимально возможный"]]);
            return false;
        }
        return true;
    }
}
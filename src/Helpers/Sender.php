<?php

namespace App\Helpers;

use App\Config;
use App\Model\Subscribed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

use function helpers\makeShortAnnotation;

class Sender
{
    /**
     * Коллекция email ов для рассылки
     *
     * @var Builder[]|Collection
     */
    private $emailList;

    /**
     * Сообщение для отправки
     *
     * @var string
     */
    private $msg;


    /**
     * Массив с настройками шифрования для email
     *
     * @var array
     */
    private static $emailEncrypt = [];

    /**
     * Sender constructor.
     *
     * @param string $title заголовок статьи
     * @param string $text текст статьи
     * @param string $ref ссылка на статью
     */
    public function __construct(string $title, string $text, string $ref)
    {
        self::initialize();
        $this->emailList = Subscribed::query()
            ->where('is_active', '=', 1)
            ->get();

        $this->msg =
            "Заголовок письма: На сайте добавлена новая запись: " . $title . "\n" .
            "  Содержимое письма:" .
            "  Новая статья: " . $title . "\n" .
            makeShortAnnotation($text) . "\n" .
            "Читать: " . $ref . "\n";
    }

    /**
     * Инициализация настроек шифрования из Config
     */
    private static function initialize()
    {
        $configs = Config::getInstance();
        self::$emailEncrypt = $configs->get('encrypt.email');

    }

    /**
     * Отправляет письма с уведомлениями
     */
    public function send()
    {
        foreach ($this->emailList as $row) {
            $msg = "\n" . "\n" .
                "--------------------------------------------------------------------------------------------" . "\n" .
                "Время отправки: " . date('Y-m-d H:i:s') . "\n" .
                "Адресат отправки " . $row->email . "\n" .
                "****************" . "\n" .
                $this->msg . "\n" .
                "Отписаться: " . BASE_URL . "/?email=" . $this->encryptEmail($row->email) . "&unsubscribe=yes";
            $this->log($msg);
        }
    }

    /**
     * Логирование отправки писем в файл /tmp/sender.log
     *
     * @param $msg
     */
    protected function log($msg)
    {
        file_put_contents(PATH_TO_SENDER_LOG, $msg, FILE_APPEND);
    }

    /**
     * Шифрование email для последующего использования в ссылке на отписку с GET параметрами
     *
     * @param $email
     * @return string
     */
    protected function encryptEmail($email)
    {
        $op = self::$emailEncrypt;
        $ciphertext_raw = openssl_encrypt($email, $op['method'], $op['key'], $options=$op['options'], $op['iv']);
        $hmac = hash_hmac($op['algo'], $ciphertext_raw, $op['key'], $as_binary=$op['asBinary']);

        return base64_encode( $op['key'].$hmac.$ciphertext_raw );
    }

    /**
     * Расшифровка email
     *
     * @param $email
     * @return string|null
     */
    public static function decryptEmail($email)
    {
        self::initialize();
        $op = self::$emailEncrypt;
        $rawStr = str_replace(' ', '+', $email);
        $c = base64_decode($rawStr);
        $ivLen = openssl_cipher_iv_length($cipher=$op['method']);
        $hMac = substr($c, $ivLen, $sha2Len=$op['sha2Len']);
        $cipherTextRaw = substr($c, $ivLen+$sha2Len);
        $originalPlainText = openssl_decrypt($cipherTextRaw, $op['method'], $op['key'], $options=$op['options'], $op['iv']);
        $calcMac = hash_hmac($op['algo'], $cipherTextRaw, $op['key'], $as_binary=$op['asBinary']);
        if (hash_equals($hMac, $calcMac))
        {
            $originalPlainText;
        }

        return isset($originalPlainText) ? $originalPlainText : null;
    }
}
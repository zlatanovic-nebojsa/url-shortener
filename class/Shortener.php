<?php

class Shortener extends Database
{
    private $pdo = NULL;

    public function __construct()
    {
        $this->pdo = parent::getInstance();
    }

    protected function generateCode($num)
    {
        return base_convert($num, 10, 36);
    }

    public function makeCode($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return '';
        }

        // check if URL already exists
        $sql = "SELECT code FROM links WHERE url = ?";

        $exists = $this->pdo->query($sql, [$url]);

        if ($exists->count()) {
            // return code
            return $exists->first()->code;
        } else {

            $date = date('Y-m-d H:i:s');

            // insert record without code
            $this->pdo->insert('links', [
                "url" => $url,
                "created" => $date
            ]);

            // generate code based on inserted ID
            $code = $this->generateCode($this->pdo->lastInsertId());
            // update the record with the generated code
            $this->pdo->update('links', $this->pdo->lastInsertId(), [
                "code" => $code
            ]);

            return $code;
        }
    }

    public function getUrl($code)
    {
        $sql = "SELECT url FROM links WHERE code = ?";

        $exists = $this->pdo->query($sql, [$code]);

        if ($exists->count()) {
            return $exists->first()->url;
        }

        return '';
    }
}
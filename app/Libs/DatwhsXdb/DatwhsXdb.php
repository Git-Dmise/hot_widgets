<?php

/**
 * @noinspection PhpMissingDocCommentInspection
 * @noinspection PhpUnused
 */

namespace App\Libs\DatwhsXdb;

use Exception;

class DatwhsXdb
{
    protected const VECTOR_INDEX_SIZE = 8;
    protected const VECTOR_INDEX_COLS = 256;

    protected const SEGMENT_INDEX_SIZE = 14;
    protected const HEADER_INFO_LENGTH = 256;

    protected $handle;

    protected int $ioCount = 0;

    public function __construct($dbFile)
    {
        $this->handle = fopen($dbFile, 'r');
    }

    /**
     * @throws Exception
     */
    public function search(string|int $ip): string|null
    {
        if (is_string($ip)) {
            $ip = ip2long($ip);
        }

        $this->ioCount = 0;

        $il0 = ($ip >> 24) & 0xFF;
        $il1 = ($ip >> 16) & 0xFF;

        $idx = $il0
            * self::VECTOR_INDEX_COLS
            * self::VECTOR_INDEX_SIZE
            + $il1
            * self::VECTOR_INDEX_SIZE;

        if (is_null($buff = $this->read(self::HEADER_INFO_LENGTH + $idx, 8))) {
            throw new Exception("failed to read vector index at {$idx}");
        }

        $s_ptr = self::getLong($buff, 0);
        $e_ptr = self::getLong($buff, 4);

        $l = 0;
        $data_len = 0;
        $data_ptr = null;
        $h = ($e_ptr - $s_ptr) / self::SEGMENT_INDEX_SIZE;

        while ($l <= $h) {
            $m = ($l + $h) >> 1;
            $p = $s_ptr + $m * self::SEGMENT_INDEX_SIZE;

            if (($buff = $this->read($p, self::SEGMENT_INDEX_SIZE)) == null) {
                throw new Exception("failed to read segment index at {$p}");
            }

            if ($ip < self::getLong($buff, 0)) {
                $h = $m - 1;
            }

            elseif ($ip > self::getLong($buff, 4)) {
                $l = $m + 1;
            }

            else {
                $data_len = self::getShort($buff, 8);
                $data_ptr = self::getLong($buff, 10);
                break;
            }
        }

        if (is_null($data_ptr)) {
            return null;
        }

        if (is_null($buff = $this->read($data_ptr, $data_len))) {
            return null;
        }

        return $buff;
    }

    protected function read($offset, $len): string|null
    {
        if (fseek($this->handle, $offset) === -1) {
            return null;
        }

        $this->ioCount++;

        if (($buff = fread($this->handle, $len)) === false) {
            return null;
        }

        if (strlen($buff) != $len) {
            return null;
        }

        return $buff;
    }

    public static function getLong($b, $idx): float|int|string
    {
        $val = (ord($b[$idx])) | (ord($b[$idx + 1]) << 8)
            | (ord($b[$idx + 2]) << 16) | (ord($b[$idx + 3]) << 24);

        if ($val < 0 && PHP_INT_SIZE == 4) {
            $val = sprintf('%u', $val);
        }

        return $val;
    }

    public static function getShort($b, $idx): int
    {
        return ((ord($b[$idx])) | (ord($b[$idx + 1]) << 8));
    }
}

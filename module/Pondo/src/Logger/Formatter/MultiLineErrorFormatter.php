<?php

namespace Pondo\Logger\Formatter;

use Monolog\Formatter\FormatterInterface;

/**
 * Class MultiLineErrorFormatter
 */
class MultiLineErrorFormatter implements FormatterInterface
{
    const LINE_FORMAT = "[%datetime%] %channel%.%level_name%: %message% %context.http_method%%context.http_uri%%context.exception%\n";
    const DATE_FORMAT = 'Y-m-d\TH:i:sP';

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $dateFormat;

    /**
     * MultiLineErrorFormatter constructor.
     */
    public function __construct()
    {
        $this->format = self::LINE_FORMAT;
        $this->dateFormat = self::DATE_FORMAT;
    }

    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record)
    {
        $data = $record;
        /** @var \DateTimeImmutable $date */
        $date = $data['datetime'];

        $data['datetime'] = $date->format($this->dateFormat);
        $indent = 8;
// add three

        $output = $this->format;

        foreach ($data['extra'] as $var => $val) {
            if (false !== strpos($output, '%extra.' . $var . '%')) {
                if ($val instanceof \Throwable) {
                    $output = str_replace(
                        '%extra.' .
                        $var . '%',
                        "\n" .
                        str_repeat(' ', $indent) .
                        $this->indentString($this->normalizeException($val), $indent),
                        $output
                    );
                } else {
                    $output = str_replace(
                        '%extra.' .
                        $var . '%',
                        "\n" .
                        str_repeat(' ', $indent) .
                        $this->indentString($this->normalize($val), $indent),
                        $output
                    );
                }
                unset($data['extra'][$var]);
            }
        }

        foreach ($data['context'] as $var => $val) {
            if (false !== strpos($output, '%context.' . $var . '%')) {
                if ($val instanceof \Throwable) {
                    $output = str_replace(
                        '%context.' .
                        $var . '%',
                        "\n" .
                        str_repeat(' ', $indent) .
                        $this->indentString($this->normalizeException($val), $indent),
                        $output
                    );
                } else {
                    $output = str_replace(
                        '%context.' .
                        $var . '%',
                        "\n" .
                        str_repeat(' ', $indent) .
                        $this->indentString($this->normalize($val), $indent),
                        $output
                    );
                }
                unset($data['context'][$var]);
            }
        }

        if (empty($data['context'])) {
            unset($data['context']);
            $output = str_replace('%context%', '', $output);
        }

        if (empty($data['extra'])) {
            unset($data['extra']);
            $output = str_replace('%extra%', '', $output);
        }

        foreach ($data as $var => $value) {
            if (false !== strpos($output, '%' . $var . '%')) {
                $output = str_replace('%' . $var . '%', $this->indentString($this->normalize($value), $indent), $output);
            }
        }

        // remove leftover %extra.xxx% and %context.xxx% if any
        if (false !== strpos($output, '%')) {
            $output = preg_replace('/%(?:extra|context)\..+?%/', '', $output);
        }

        $output = rtrim($output) . "\n";

        return $output;
    }

    // phpcs:disable Squiz.Commenting.FunctionComment
    /**
     * @param $data
     * @return string
     */
    protected function normalize($data): string
    {
        return print_r($data, true);
    }
    // phpcs:enable

    /**
     * @param \Throwable $e
     * @return string
     */
    protected function normalizeException(\Throwable $e): string
    {
        $str = "\n" . $e->getTraceAsString() . "\n";

        return $str;
    }

    /**
     * @param string  $data
     * @param integer $indent
     * @return string
     */
    protected function indentString(string $data, int $indent = 0): string
    {
        return str_replace(["\r\n", "\n", "\r"], "\n" . str_repeat(' ', $indent), $data);
    }

    /**
     * Formats a set of log records.
     *
     * @param  array $records A set of records to format
     * @return mixed The formatted set of records
     */
    public function formatBatch(array $records)
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }

        return $records;
    }
}

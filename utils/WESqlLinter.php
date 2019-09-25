<?php
namespace app\utils;

use PhpMyAdmin\SqlParser\Lexer;
use PhpMyAdmin\SqlParser\Parser;
use PhpMyAdmin\SqlParser\UtfString;
use PhpMyAdmin\SqlParser\Utils\Error as ParserError;

class WESqlLinter {
    public static function getLines($str) {
        if ((!($str instanceof UtfString))
            && (defined('USE_UTF_STRINGS')) && (USE_UTF_STRINGS)
        ) {
            $str = new UtfString($str);
        }
        $len = ($str instanceof UtfString) ?
        $str->length() : strlen($str);
        $lines = array(0);
        for ($i = 0; $i < $len; ++$i) {
            if ("\n" === $str[$i]) {
                $lines[] = $i + 1;
            }
        }
        return $lines;
    }

    public static function findLineNumberAndColumn(array $lines, $pos) {
        $line = 0;
        foreach ($lines as $lineNo => $lineStart) {
            if ($lineStart > $pos) {
                break;
            }
            $line = $lineNo;
        }
        return array($line, $pos - $lines[$line]);
    }

    public static function lint($query) {
        // Disabling lint for huge queries to save some resources.
        if (mb_strlen($query) > 10000) {
            return array(
                array(
                    'message' => (
                        'Linting is disabled for this query because it exceeds the '
                        . 'maximum length.'
                    ),
                    'fromLine' => 0,
                    'fromColumn' => 0,
                    'toLine' => 0,
                    'toColumn' => 0,
                    'severity' => 'warning',
                ),
            );
        }

        $lexer = new Lexer($query);

        $parser = new Parser($lexer->list);

        $errors = ParserError::get(array($lexer, $parser));
        
        $response = array();

        $lines = static::getLines($query);

        foreach ($errors as $idx => $error) {

            list($fromLine, $fromColumn) = static::findLineNumberAndColumn(
                $lines, $error[3]
            );

            list($toLine, $toColumn) = static::findLineNumberAndColumn(
                $lines, $error[3] + mb_strlen($error[2])
            );

            $response[$fromLine][] = array(
                'message' => sprintf(
                    '%1$s (near <code>%2$s</code>)',
                    htmlspecialchars($error[0]), htmlspecialchars($error[2])
                ),
                'fromLine' => $fromLine,
                'fromColumn' => $fromColumn,
                'toLine' => $toLine,
                'toColumn' => $toColumn,
                'severity' => 'error',
            );
        }
        return $response;
    }
}
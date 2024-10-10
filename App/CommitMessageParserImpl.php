<?php
namespace App;

use InvalidArgumentException;

class CommitMessageParserImpl implements CommitMessageParser
{
    public function parse(string $message): CommitMessage {
        // Opravený regulární výraz pro zpracování ID úkolu jako volitelného
        preg_match('/^\[([^\]]+)\] \[([^\]]+)\] @([^\s]+)(?: #(\d+))? (.+)$/m', $message, $headerMatches);

        if (!$headerMatches) {
            throw new InvalidArgumentException("Commit message není ve správném formátu");
        }

        $tags = [$headerMatches[1], $headerMatches[2]];
        $taskId = isset($headerMatches[4]) && $headerMatches[4] !== '' ? (int)$headerMatches[4] : null; // Kontrola, zda je taskId prázdné
        $title = trim($headerMatches[5]);

        $details = [];
        $bcBreaks = [];
        $todos = [];

        $lines = explode("\n", $message);
        foreach ($lines as $line) {
            if (strpos($line, '*') === 0) {
                $details[] = trim(substr($line, 1));
            } elseif (strpos($line, 'BC:') === 0) {
                $bcBreaks[] = trim(substr($line, 3));
            } elseif (strpos($line, 'TODO:') === 0) {
                $todos[] = trim(substr($line, 5));
            }
        }

        return new ParsedCommitMessage($title, $taskId, $tags, $details, $bcBreaks, $todos);
    }
}

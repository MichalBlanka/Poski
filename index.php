<?php

require_once 'App/CommitMessage.php';
require_once 'App/CommitMessageParser.php';
require_once 'App/ParsedCommitMessage.php';
require_once 'App/CommitMessageParserImpl.php';

use App\CommitMessageParserImpl;
$parser = new CommitMessageParserImpl();

$commitMessage = '[add] [feature] @core #123456 Integrovat Premier: export objednávek
* Export objednávek cronem co hodinu.
* Export probíhá v dávkách.
BC: Refaktorovaný BaseImporter.
TODO: Refactoring autoemail modulu.';

$parsedMessage = $parser->parse($commitMessage);

// Výpis informací
echo "Title: " . $parsedMessage->getTitle() . "\n";
echo "Task ID: " . $parsedMessage->getTaskId() . "\n";
echo "Tags: " . implode(', ', $parsedMessage->getTags()) . "\n";
echo "Details: " . implode(', ', $parsedMessage->getDetails()) . "\n";
echo "BC Breaks: " . implode(', ', $parsedMessage->getBCBreaks()) . "\n";
echo "TODOs: " . implode(', ', $parsedMessage->getTodos()) . "\n";

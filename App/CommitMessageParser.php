<?php
namespace App;
interface CommitMessageParser
{
    public function parse(string $message): CommitMessage;
}

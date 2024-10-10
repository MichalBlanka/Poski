<?php
namespace Tests;

use App\CommitMessageParserImpl;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;


require '../vendor/autoload.php';
class CommitMessageParserImplTest extends TestCase
{
    private CommitMessageParserImpl $parser;

    protected function setUp(): void
    {
        $this->parser = new CommitMessageParserImpl();
    }

    public function testValidCommitMessage()
    {
        $commitMessage = '[add] [feature] @core #123456 Integrovat Premier: export objednávek
* Export objednávek cronem co hodinu.
* Export probíhá v dávkách.
BC: Refaktorovaný BaseImporter.
TODO: Refactoring autoemail modulu.';


        $parsed = $this->parser->parse($commitMessage);

        $this->assertEquals('Integrovat Premier: export objednávek', trim($parsed->getTitle()));

        $this->assertEquals(123456, $parsed->getTaskId());
        $this->assertEquals(['add', 'feature'], $parsed->getTags());
        $this->assertEquals(
            ['Export objednávek cronem co hodinu.', 'Export probíhá v dávkách.'],
            $parsed->getDetails()
        );
        $this->assertEquals(['Refaktorovaný BaseImporter.'], $parsed->getBCBreaks());
        $this->assertEquals(['Refactoring autoemail modulu.'], $parsed->getTodos());
    }

    public function testCommitMessageWithoutTaskId()
    {
        $commitMessage = '[add] [feature] @core Integrovat Premier: export objednávek
* Export objednávek cronem co hodinu.';


        $parsed = $this->parser->parse($commitMessage);

        $this->assertNull($parsed->getTaskId());

    }

    public function testInvalidCommitMessage()
    {
        $this->expectException(InvalidArgumentException::class);

        $invalidMessage = 'Invalid commit message format';
        $this->parser->parse($invalidMessage);
    }
}

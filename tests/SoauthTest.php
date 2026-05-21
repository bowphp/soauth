<?php

declare(strict_types=1);

use Bow\Soauth\Exception\SoauthException;
use Bow\Soauth\Soauth;
use PHPUnit\Framework\TestCase;

final class SoauthTest extends TestCase
{
    protected function setUp(): void
    {
        // Reset the static config between tests so each starts from a clean slate.
        Soauth::configure([]);
    }

    public function testUnknownProviderThrowsWithSupportedList(): void
    {
        $this->expectException(SoauthException::class);
        $this->expectExceptionMessage('Unknown soauth provider "nope"');

        Soauth::redirect('nope');
    }

    public function testKnownButUnconfiguredProviderThrowsActionableError(): void
    {
        $this->expectException(SoauthException::class);
        $this->expectExceptionMessage('Soauth provider "github" is not configured');

        Soauth::redirect('github');
    }

    public function testListsAllSupportedProvidersInUnknownError(): void
    {
        try {
            Soauth::redirect('nope');
            $this->fail('Expected SoauthException for unknown provider.');
        } catch (SoauthException $e) {
            foreach (['facebook', 'gitlab', 'github', 'google', 'linkedin', 'instagram'] as $name) {
                $this->assertStringContainsString($name, $e->getMessage());
            }
        }
    }
}

<?php

declare(strict_types=1);

use Bow\Soauth\UserResource;
use PHPUnit\Framework\TestCase;

final class UserResourceTest extends TestCase
{
    public function testAllGettersReturnNullForEmptyAttributes(): void
    {
        $user = new UserResource([]);

        $this->assertNull($user->getId());
        $this->assertNull($user->getName());
        $this->assertNull($user->getNickName());
        $this->assertNull($user->getFirstName());
        $this->assertNull($user->getLastName());
        $this->assertNull($user->getEmail());
        $this->assertNull($user->getPictureUrl());
        $this->assertNull($user->getCoverPhotoUrl());
        $this->assertNull($user->getGender());
        $this->assertNull($user->getLink());
        $this->assertNull($user->getMinAge());
        $this->assertNull($user->getMaxAge());
    }

    public function testFlatAttributesAreReturnedAsIs(): void
    {
        $user = new UserResource([
            'id'         => '42',
            'name'       => 'Ada Lovelace',
            'email'      => 'ada@example.test',
            'nickname'   => 'ada',
            'first_name' => 'Ada',
            'last_name'  => 'Lovelace',
        ]);

        $this->assertSame('42', $user->getId());
        $this->assertSame('Ada Lovelace', $user->getName());
        $this->assertSame('ada@example.test', $user->getEmail());
        $this->assertSame('ada', $user->getNickName());
        $this->assertSame('Ada', $user->getFirstName());
        $this->assertSame('Lovelace', $user->getLastName());
    }

    /**
     * Facebook returns the avatar nested under picture.data.url. The constructor
     * is supposed to normalise that into a flat `picture_url` so getPictureUrl()
     * works the same across providers.
     */
    public function testNestedFacebookPictureIsNormalised(): void
    {
        $user = new UserResource([
            'picture' => [
                'data' => [
                    'url'           => 'https://cdn.example.test/ada.png',
                    'is_silhouette' => false,
                ],
            ],
        ]);

        $this->assertSame('https://cdn.example.test/ada.png', $user->getPictureUrl());
        $this->assertFalse($user->isDefaultPicture());
    }

    public function testFlatPictureUrlIsPreservedWhenNoNestedShape(): void
    {
        $user = new UserResource([
            'picture_url' => 'https://cdn.example.test/from-github.png',
        ]);

        $this->assertSame('https://cdn.example.test/from-github.png', $user->getPictureUrl());
    }

    public function testCoverPhotoUrlIsNormalisedFromNestedShape(): void
    {
        $user = new UserResource([
            'cover' => ['source' => 'https://cdn.example.test/cover.png'],
        ]);

        $this->assertSame('https://cdn.example.test/cover.png', $user->getCoverPhotoUrl());
    }

    public function testAgeRangeBounds(): void
    {
        $user = new UserResource([
            'age_range' => ['min' => 21, 'max' => 30],
        ]);

        $this->assertSame(21, $user->getMinAge());
        $this->assertSame(30, $user->getMaxAge());
    }

    public function testToArrayContainsOriginalAttributesPlusNormalisedKeys(): void
    {
        $user = new UserResource([
            'name'    => 'Ada',
            'picture' => ['data' => ['url' => 'https://x.test/p.png']],
        ]);

        $arr = $user->toArray();

        $this->assertSame('Ada', $arr['name']);
        $this->assertSame('https://x.test/p.png', $arr['picture_url']);
        // Original nested shape is still present, not destroyed.
        $this->assertSame('https://x.test/p.png', $arr['picture']['data']['url']);
    }

    public function testGetAttributeFallsBackToNullForUnknownKey(): void
    {
        $user = new UserResource(['name' => 'Ada']);

        $this->assertSame('Ada', $user->getAttribute('name'));
        $this->assertNull($user->getAttribute('does_not_exist'));
    }
}

<?php

namespace Bow\Soauth;

class UserResource
{
    /**
     * User information collection
     *
     * @var array
     */
    private $attributes;

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;

        if (!isset($attributes['picture']['data']['url']) && !empty($attributes['picture']['data']['url'])) {
            $this->attributes['picture_url'] = $attributes['picture']['data']['url'];
        }

        if (isset($attributes['picture']['data']['is_silhouette'])) {
            $this->attributes['is_silhouette'] = $attributes['picture']['data']['is_silhouette'];
        }

        if (isset($response['cover']['source']) && !empty($response['cover']['source'])) {
            $this->attributes['cover_photo_url'] = $attributes['cover']['source'];
        }
    }

    /**
     * Returns the ID for the user as a string if present.
     *
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->getAttribute('id');
    }

    /**
     * Returns the name for the user as a string if present.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->getAttribute('name');
    }

    /**
     * Returns the nickname for the user as a string if present.
     *
     * @return ?string
     */
    public function getNickName(): ?string
    {
        return $this->getAttribute('nickname');
    }

    /**
     * Returns the first name for the user as a string if present.
     *
     * @return ?string
     */
    public function getFirstName(): ?string
    {
        return $this->getAttribute('first_name');
    }

    /**
     * Returns the last name for the user as a string if present.
     *
     * @return ?string
     */
    public function getLastName(): ?string
    {
        return $this->getAttribute('last_name');
    }

    /**
     * Returns the email for the user as a string if present.
     *
     * @return ?string
     */
    public function getEmail(): ?string
    {
        return $this->getAttribute('email');
    }

    /**
     * Returns the current location of the user as an array.
     *
     * @return array|null
     */
    public function getHometown(): ?array
    {
        return $this->getAttribute('hometown');
    }

    /**
     * Returns the "about me" bio for the user as a string if present.
     *
     * @return ?string
     * @deprecated The bio field was removed in Graph v2.8
     */
    public function getBio(): ?string
    {
        return $this->getAttribute('bio');
    }

    /**
     * Returns if user has not defined a specific avatar
     *
     * @return boolean
     */

    public function isDefaultPicture(): bool
    {
        return $this->getAttribute('is_silhouette');
    }

    /**
     * Returns the profile picture of the user as a string if present.
     *
     * @return ?string
     */
    public function getPictureUrl(): ?string
    {
        return $this->getAttribute('picture_url');
    }

    /**
     * Returns the cover photo URL of the user as a string if present.
     *
     * @return ?string
     * @deprecated
     */
    public function getCoverPhotoUrl(): ?string
    {
        return $this->getAttribute('cover_photo_url');
    }

    /**
     * Returns the gender for the user as a string if present.
     *
     * @return ?string
     */
    public function getGender(): ?string
    {
        return $this->getAttribute('gender');
    }

    /**
     * Returns the locale of the user as a string if available.
     *
     * @return ?string
     * @deprecated
     */
    public function getLocale(): ?string
    {
        return $this->getAttribute('locale');
    }

    /**
     * Returns the Facebook URL for the user as a string if available.
     *
     * @return ?string
     */
    public function getLink(): ?string
    {
        return $this->getAttribute('link');
    }

    /**
     * Returns the current timezone offset from UTC (from -24 to 24)
     *
     * @return float|null
     * @deprecated
     */
    public function getTimezone(): ?float
    {
        return $this->getAttribute('timezone');
    }

    /**
     * Returns the lower bound of the user's age range
     *
     * @return integer|null
     */
    public function getMinAge(): ?int
    {
        return $this->attributes['age_range']['min'] ?? null;
    }

    /**
     * Returns the upper bound of the user's age range
     *
     * @return integer|null
     */
    public function getMaxAge(): ?int
    {
        return $this->attributes['age_range']['max'] ?? null;
    }

    /**
     * Returns all the data obtained about the user.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Returns a field from the Graph node data.
     *
     * @return mixed|null
     */
    private function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }
}

<?php
class Recipe
{
    private int $id;
    private string $user_id;
    private string $title;
    private string $content;

    public function __construct($user_id, $title, $content)
    {
        $this->user_id = $user_id;
        $this->title = $title;
        $this->content = $content;
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getUserId(): string
    {
        return $this->user_id;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function getContent(): string
    {
        return $this->content;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }
    public function settitle(string $title): void
    {
        $this->title = $title;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}

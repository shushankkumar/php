<?php
// Base Member Class
class Member {
    protected $username;
    protected $email;
    protected $posts = [];

    public function __construct($username, $email) {
        $this->username = $username;
        $this->email = $email;
    }

    public function createPost($content) {
        $postId = count($this->posts) + 1;
        $this->posts[$postId] = $content;
        echo "Post created: {$content}<br>";
    }

    public function editProfile($newUsername, $newEmail) {
        $this->username = $newUsername;
        $this->email = $newEmail;
        echo "Profile updated: Username - {$this->username}, Email - {$this->email}<br>";
    }

    public function showProfile() {
        echo "<b>Profile Details:</b><br>";
        echo "Username: {$this->username}<br>";
        echo "Email: {$this->email}<br>";
        echo "Posts:<br>";
        foreach ($this->posts as $id => $content) {
            echo "Post {$id}: {$content}<br>";
        }
    }

    public function login() {
        echo "{$this->username} logged in.<br>";
    }

    public function logout() {
        echo "{$this->username} logged out.<br>";
    }
}

// Administrator Class (Child of Member)
class Administrator extends Member {
    private $forums = [];

    public function createForum($forumName) {
        $this->forums[] = $forumName;
        echo "Forum '{$forumName}' created.<br>";
    }

    public function deleteForum($forumName) {
        $index = array_search($forumName, $this->forums);
        if ($index !== false) {
            unset($this->forums[$index]);
            echo "Forum '{$forumName}' deleted.<br>";
        } else {
            echo "Forum '{$forumName}' not found.<br>";
        }
    }

    public function banMember($member) {
        echo "Member '{$member->username}' has been banned.<br>";
    }

    public function showForums() {
        echo "<b>Forums:</b><br>";
        foreach ($this->forums as $forum) {
            echo "- {$forum}<br>";
        }
    }

    // Overriding login method
    public function login() {
        echo "Administrator {$this->username} logged in with extra privileges.<br>";
    }

    // Overriding logout method
    public function logout() {
        echo "Administrator {$this->username} logged out.<br>";
    }
}

// Example Usage
echo "<h3>Member Operations</h3>";
$member = new Member("JohnDoe", "john@example.com");
$member->login();
$member->createPost("Hello, this is my first post!");
$member->showProfile();
$member->editProfile("Johnny", "johnny@example.com");
$member->logout();

echo "<h3>Administrator Operations</h3>";
$admin = new Administrator("AdminUser", "admin@example.com");
$admin->login();
$admin->createForum("General Discussion");
$admin->createForum("Announcements");
$admin->showForums();
$admin->deleteForum("General Discussion");
$admin->showForums();
$admin->banMember($member);
$admin->logout();
?>
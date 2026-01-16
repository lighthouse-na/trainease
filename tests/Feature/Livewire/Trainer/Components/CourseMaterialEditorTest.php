<?php

use App\Models\Training\Course;
use App\Models\Training\CourseMaterial;
use App\Models\User;
use Livewire\Volt\Volt;
use Spatie\Permission\Models\Role;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

/**
 * @property \App\Models\User $user
 * @property \App\Models\Training\Course $course
 */

beforeEach(function () {
    if (! Role::where('name', 'trainer')->exists()) {
        Role::create(['name' => 'trainer']);
    }

    $this->user = User::make();
    $this->user->assignRole(Role::findByName('trainer'));
    actingAs($this->user);

    $this->course = Course::factory()->createOne();
});

it('renders successfully', function () {
    Volt::test('trainer.components.course-creator', ['course' => $this->course->id])
        ->assertStatus(200);
});

it('can add a heading 1 block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addBlock', 'heading1');
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('heading1');
});

it('can add a heading 2 block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addBlock', 'heading2');
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('heading2');
});

it('can add a heading 3 block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addBlock', 'heading3');
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('heading3');
});

it('can add a text block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addBlock', 'text');
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('text');
});

it('can add a list item, creating a new list block if none exists', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addListItem');
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('list');
    expect($component->contentBlocks[0]['items'])->toHaveCount(1);
    expect($component->contentBlocks[0]['items'][0]['type'])->toBe('list-item');
});

it('can add a list item to an existing list block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addListItem'); // Add first item, creates list block
    $component->call('addListItem'); // Add second item to existing list block
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('list');
    expect($component->contentBlocks[0]['items'])->toHaveCount(2);
});

it('can remove a non-list content block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addBlock', 'text');
    $component->call('addBlock', 'heading1');
    expect($component->contentBlocks)->toHaveCount(2);
    $component->call('removeContentBlock', 0);
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('heading1');
});

it('can remove a list item from a list block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addListItem');
    $component->call('addListItem');
    expect($component->contentBlocks[0]['items'])->toHaveCount(2);
    $component->call('removeContentBlock', 0, 0);
    expect($component->contentBlocks[0]['items'])->toHaveCount(1);
});

it('removes the list block if the last list item is removed', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addListItem');
    expect($component->contentBlocks)->toHaveCount(1);
    $component->call('removeContentBlock', 0, 0);
    expect($component->contentBlocks)->toHaveCount(0);
});

it('loads existing material content and parses markdown into blocks', function () {
    $markdownContent = "# Heading One\n## Heading Two\nSome text content.\n- List item one\n- List item two";
    $material = CourseMaterial::factory()->createOne([
        'course_id' => $this->course->id,
        'material_content' => $markdownContent,
    ]);

    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('loadMaterial', $material->id);

    expect($component->contentBlocks)->toHaveCount(4);
    expect($component->contentBlocks[0]['type'])->toBe('heading1');
    expect($component->contentBlocks[0]['content'])->toBe('Heading One');
    expect($component->contentBlocks[1]['type'])->toBe('heading2');
    expect($component->contentBlocks[1]['content'])->toBe('Heading Two');
    expect($component->contentBlocks[2]['type'])->toBe('text');
    expect($component->contentBlocks[2]['content'])->toBe('Some text content.');
    expect($component->contentBlocks[3]['type'])->toBe('list');
    expect($component->contentBlocks[3]['items'])->toHaveCount(2);
    expect($component->contentBlocks[3]['items'][0]['content'])->toBe('List item one');
    expect($component->contentBlocks[3]['items'][1]['content'])->toBe('List item two');
});

it('updates material content, generating markdown from blocks', function () {
    $material = CourseMaterial::factory()->createOne([
        'course_id' => $this->course->id,
        'material_content' => '',
    ]);

    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('loadMaterial', $material->id);

    $component->call('addBlock', 'heading1');
    $component->set('contentBlocks.0.content', 'New Heading');
    $component->call('addBlock', 'text');
    $component->set('contentBlocks.1.content', 'New text content.');
    $component->call('addListItem');
    $component->set('contentBlocks.2.items.0.content', 'New list item.');

    $component->call('updateMaterial');

    $updatedMaterial = CourseMaterial::find($material->id);
    expect($updatedMaterial->material_content)->toBe("# New Heading\nNew text content.\n- New list item.");
});

it('can add a video block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('addBlock', 'video');
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('video');
    expect($component->contentBlocks[0]['youtube_url'])->toBe('');
});

it('normalizes YouTube URLs when adding a video block', function () {
    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $youtubeLink = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
    $expectedEmbedUrl = 'https://www.youtube.com/embed/dQw4w9WgXcQ';

    $component->call('addVideoBlock', $youtubeLink);
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('video');
    expect($component->contentBlocks[0]['youtube_url'])->toBe($expectedEmbedUrl);

    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $youtubeLink = 'https://youtu.be/dQw4w9WgXcQ';
    $expectedEmbedUrl = 'https://www.youtube.com/embed/dQw4w9WgXcQ';

    $component->call('addVideoBlock', $youtubeLink);
    expect($component->contentBlocks)->toHaveCount(1);
    expect($component->contentBlocks[0]['type'])->toBe('video');
    expect($component->contentBlocks[0]['youtube_url'])->toBe($expectedEmbedUrl);
});

it('loads existing material content with video and parses it into blocks', function () {
    $youtubeEmbed = '<iframe width="560" height="315" src="https://www.youtube.com/embed/testvideo123" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
    $markdownContent = "# Heading One\n" . $youtubeEmbed . "\nSome text content.";
    $material = CourseMaterial::factory()->createOne([
        'course_id' => $this->course->id,
        'material_content' => $markdownContent,
    ]);

    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('loadMaterial', $material->id);

    expect($component->contentBlocks)->toHaveCount(3);
    expect($component->contentBlocks[0]['type'])->toBe('heading1');
    expect($component->contentBlocks[1]['type'])->toBe('video');
    expect($component->contentBlocks[1]['youtube_url'])->toBe('https://www.youtube.com/embed/testvideo123');
    expect($component->contentBlocks[2]['type'])->toBe('text');
});

it('updates material content, generating markdown from video blocks', function () {
    $material = CourseMaterial::factory()->createOne([
        'course_id' => $this->course->id,
        'material_content' => '',
    ]);

    $component = Volt::test('trainer.components.course-creator', ['course' => $this->course->id]);
    $component->call('loadMaterial', $material->id);

    $component->call('addBlock', 'video');
    $component->set('contentBlocks.0.youtube_url', 'https://www.youtube.com/embed/newvideo456');

    $component->call('updateMaterial');

    $updatedMaterial = CourseMaterial::find($material->id);
    $expectedMarkdown = '<iframe width="560" height="315" src="https://www.youtube.com/embed/newvideo456" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
    expect($updatedMaterial->material_content)->toBe($expectedMarkdown);
});

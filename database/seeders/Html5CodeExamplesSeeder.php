<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\CodeExample;

class Html5CodeExamplesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Code examples for various lessons
        $codeExamples = [
            [
                'lesson_title' => '2.6 Your First Web Page',
                'title' => 'Basic HTML5 Document',
                'code' => '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My First Web Page</title>
</head>
<body>
  <p>Hello, world!</p>
</body>
</html>',
                'explanation' => 'This is the basic structure of an HTML5 document. It includes the DOCTYPE declaration, html element with language attribute, head section with meta charset and title, and body section with content.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.3 Web Page Template',
                'title' => 'HTML5 Page Template',
                'code' => '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Page description goes here">
  <title>Page Title</title>
</head>
<body>
  <!-- Page content goes here -->
</body>
</html>',
                'explanation' => 'A complete HTML5 template with essential meta tags including viewport for responsive design and description for SEO.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.7 Heading Element',
                'title' => 'HTML Headings Example',
                'code' => '<h1>Main Page Heading</h1>
<h2>Section Heading</h2>
<h3>Subsection Heading</h3>
<h4>Sub-subsection Heading</h4>
<h5>Minor Heading</h5>
<h6>Smallest Heading</h6>',
                'explanation' => 'HTML provides six levels of headings from h1 (largest/most important) to h6 (smallest/least important). Use them to create a proper document outline.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.12 Ordered List',
                'title' => 'Ordered List Example',
                'code' => '<h3>Steps to Make a Website</h3>
<ol>
  <li>Plan your website structure</li>
  <li>Create HTML content</li>
  <li>Style with CSS</li>
  <li>Add interactivity with JavaScript</li>
  <li>Test and deploy</li>
</ol>

<h3>Nested Ordered List</h3>
<ol type="I">
  <li>Introduction
    <ol type="a">
      <li>Background</li>
      <li>Objectives</li>
    </ol>
  </li>
  <li>Main Content</li>
</ol>',
                'explanation' => 'Ordered lists create numbered lists. You can change numbering style with the type attribute and create nested lists.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.13 Unordered List',
                'title' => 'Unordered List Example',
                'code' => '<h3>Web Technologies</h3>
<ul>
  <li>HTML - Structure</li>
  <li>CSS - Presentation</li>
  <li>JavaScript - Behavior</li>
</ul>

<h3>Nested Lists</h3>
<ul>
  <li>Frontend
    <ul>
      <li>HTML5</li>
      <li>CSS3</li>
      <li>JavaScript</li>
    </ul>
  </li>
  <li>Backend
    <ul>
      <li>PHP</li>
      <li>Python</li>
      <li>Node.js</li>
    </ul>
  </li>
</ul>',
                'explanation' => 'Unordered lists create bulleted lists. They can be nested to create multi-level lists.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.17 Hyperlinks',
                'title' => 'Various Types of Links',
                'code' => '<!-- External link -->
<a href="https://www.example.com">Visit Example.com</a>

<!-- Internal link to another page -->
<a href="about.html">About Us</a>

<!-- Link to section on same page -->
<a href="#section2">Go to Section 2</a>

<!-- Email link -->
<a href="mailto:info@example.com">Contact Us</a>

<!-- Link opening in new window -->
<a href="https://www.example.com" target="_blank">Open in New Tab</a>

<!-- Download link -->
<a href="document.pdf" download>Download PDF</a>',
                'explanation' => 'The anchor element creates various types of links: external websites, internal pages, page sections, email addresses, and downloadable files.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.16 Structural Elements',
                'title' => 'HTML5 Semantic Structure',
                'code' => '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HTML5 Semantic Structure</title>
</head>
<body>
  <header>
    <h1>Website Title</h1>
    <nav>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>
  
  <main>
    <section>
      <h2>Main Content Section</h2>
      <article>
        <h3>Article Title</h3>
        <p>Article content goes here...</p>
      </article>
    </section>
    
    <aside>
      <h3>Related Links</h3>
      <ul>
        <li><a href="#">Link 1</a></li>
        <li><a href="#">Link 2</a></li>
      </ul>
    </aside>
  </main>
  
  <footer>
    <p>&copy; 2025 Your Website. All rights reserved.</p>
  </footer>
</body>
</html>',
                'explanation' => 'HTML5 semantic elements provide meaning to the structure: header for introductory content, nav for navigation, main for primary content, section for thematic grouping, article for self-contained content, aside for supplementary content, and footer for closing content.',
                'language' => 'html'
            ],
            [
                'lesson_title' => '2.11 Phrase Elements',
                'title' => 'Text Formatting Elements',
                'code' => '<p>This text contains <strong>important information</strong>.</p>
<p>This text has <em>emphasized words</em> for stress.</p>
<p>The book <cite>Web Development Foundations</cite> is helpful.</p>
<p>Use the <code>console.log()</code> function to debug.</p>
<p>The <abbr title="World Wide Web">WWW</abbr> changed everything.</p>
<p>Press <kbd>Ctrl</kbd> + <kbd>S</kbd> to save.</p>
<p>The formula is: <var>x</var> = <var>y</var> + 5</p>
<p>The computer said: <samp>Error 404: Not Found</samp></p>',
                'explanation' => 'Phrase elements add semantic meaning to inline text: strong for importance, em for emphasis, cite for titles, code for code snippets, abbr for abbreviations, kbd for keyboard input, var for variables, and samp for sample output.',
                'language' => 'html'
            ]
        ];

        foreach ($codeExamples as $exampleData) {
            // Find the lesson
            $lesson = Lesson::where('title', $exampleData['lesson_title'])->first();
            
            if (!$lesson) {
                $this->command->warn("Lesson not found for code example: {$exampleData['lesson_title']}");
                continue;
            }

            // Create the code example
            $codeExample = CodeExample::firstOrCreate(
                [
                    'lesson_id' => $lesson->id,
                    'title' => $exampleData['title']
                ],
                [
                    'lesson_id' => $lesson->id,
                    'title' => $exampleData['title'],
                    'description' => $exampleData['explanation'],
                    'initial_code' => $exampleData['code'],
                    'solution_code' => $exampleData['code'], // Using same code as solution since these are examples
                    'language' => $exampleData['language'],
                    'hints' => 'Study the code structure and try to understand each element.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            if ($codeExample->wasRecentlyCreated) {
                $this->command->info("Created code example: {$exampleData['title']}");
            } else {
                $this->command->info("Code example already exists: {$exampleData['title']}");
            }
        }

        $this->command->info('All code examples created successfully.');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\Activity;
use App\Models\CodeExample;

class HTMLCourseExpansionSeeder_Part2 extends Seeder
{
    public function run(): void
    {
        // Find the HTML course
        $htmlCourse = Course::where('slug', 'html5-tutorial')->first();
        
        if (!$htmlCourse) {
            echo "HTML course not found!\n";
            return;
        }

        // Create remaining lessons
        $this->createHTMLHeadingsLesson($htmlCourse);
        $this->createHTMLParagraphsLesson($htmlCourse);
        $this->createHTMLStylesLesson($htmlCourse);
        $this->createHTMLFormattingLesson($htmlCourse);
    }
    
    private function createHTMLHeadingsLesson($htmlCourse)
    {
        $lesson = Lesson::create([
            'course_id' => $htmlCourse->id,
            'title' => 'HTML Headings',
            'slug' => 'html-headings',
            'description' => 'Master HTML headings to create well-structured, accessible web content',
            'content' => '<h2>HTML Headings</h2><p>HTML headings are titles or subtitles that you want to display on a webpage. They provide structure and hierarchy to your content.</p>',
            'lesson_type' => 'text',
            'duration_minutes' => 15,
            'is_published' => true,
            'order_index' => 6,
        ]);

        // Add topics
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Introduction to HTML Headings',
            'content' => '<h3>What Are HTML Headings?</h3>
<p>HTML headings are titles or subtitles that you want to display on a webpage. They create a hierarchical structure in your content.</p>

<h3>The Six Heading Levels</h3>
<p>HTML headings are defined with the <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code> tags.</p>
<ul>
<li><code>&lt;h1&gt;</code> defines the most important heading</li>
<li><code>&lt;h6&gt;</code> defines the least important heading</li>
</ul>

<pre><code>&lt;h1&gt;Heading 1&lt;/h1&gt;
&lt;h2&gt;Heading 2&lt;/h2&gt;
&lt;h3&gt;Heading 3&lt;/h3&gt;
&lt;h4&gt;Heading 4&lt;/h4&gt;
&lt;h5&gt;Heading 5&lt;/h5&gt;
&lt;h6&gt;Heading 6&lt;/h6&gt;</code></pre>

<h3>Default Styles</h3>
<p>Browsers automatically add some white space (margin) before and after a heading. Each heading level has a different default size, with h1 being the largest and h6 the smallest.</p>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Headings Are Important',
            'content' => '<h3>Why Headings Matter</h3>
<p>Headings are more than just big, bold text. They serve several critical purposes:</p>

<h3>1. Search Engine Optimization (SEO)</h3>
<p>Search engines use headings to index the structure and content of your web pages. They analyze headings to understand:</p>
<ul>
<li>What your page is about</li>
<li>The hierarchy of information</li>
<li>Key topics and subtopics</li>
</ul>

<h3>2. Accessibility</h3>
<p>Users with visual impairments rely on screen readers, which use headings to:</p>
<ul>
<li>Navigate through the page</li>
<li>Jump to specific sections</li>
<li>Understand the page structure</li>
</ul>

<h3>3. User Experience</h3>
<p>Users often skim a page by its headings to:</p>
<ul>
<li>Find relevant information quickly</li>
<li>Understand the page organization</li>
<li>Decide if the content is relevant</li>
</ul>

<h3>Best Practice</h3>
<p>Use headings to show document structure, not just to make text big or bold. For styling purposes, use CSS instead.</p>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Proper Heading Hierarchy',
            'content' => '<h3>Creating a Logical Structure</h3>
<p>Think of headings like an outline for your content. They should follow a logical hierarchy:</p>

<pre><code>&lt;h1&gt;Main Page Title&lt;/h1&gt;
    &lt;h2&gt;Chapter or Section&lt;/h2&gt;
        &lt;h3&gt;Subsection&lt;/h3&gt;
            &lt;h4&gt;Sub-subsection&lt;/h4&gt;
    &lt;h2&gt;Another Chapter&lt;/h2&gt;
        &lt;h3&gt;Another Subsection&lt;/h3&gt;</code></pre>

<h3>Example: Travel Guide Structure</h3>
<pre><code>&lt;h1&gt;Travel Guide to Europe&lt;/h1&gt;
    &lt;h2&gt;Western Europe&lt;/h2&gt;
        &lt;h3&gt;France&lt;/h3&gt;
            &lt;h4&gt;Paris&lt;/h4&gt;
            &lt;h4&gt;Nice&lt;/h4&gt;
        &lt;h3&gt;Italy&lt;/h3&gt;
            &lt;h4&gt;Rome&lt;/h4&gt;
            &lt;h4&gt;Venice&lt;/h4&gt;
    &lt;h2&gt;Eastern Europe&lt;/h2&gt;
        &lt;h3&gt;Poland&lt;/h3&gt;
        &lt;h3&gt;Czech Republic&lt;/h3&gt;</code></pre>

<h3>Important Rules</h3>
<ul>
<li>Use only <strong>one &lt;h1&gt;</strong> per page - it represents the main topic</li>
<li>Don\'t skip heading levels (e.g., don\'t jump from h1 to h3)</li>
<li>Maintain consistent hierarchy throughout the page</li>
<li>Use headings for structure, not styling</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Styling Headings',
            'content' => '<h3>Customizing Heading Size</h3>
<p>Each HTML heading has a default size. However, you can specify the size for any heading with the <code>style</code> attribute, using the CSS <code>font-size</code> property:</p>

<pre><code>&lt;h1 style="font-size:60px;"&gt;Heading 1&lt;/h1&gt;
&lt;h2 style="font-size:40px;"&gt;Heading 2&lt;/h2&gt;
&lt;h3 style="font-size:30px;"&gt;Heading 3&lt;/h3&gt;</code></pre>

<h3>Other Styling Options</h3>
<pre><code>&lt;!-- Color --&gt;
&lt;h1 style="color: blue;"&gt;Blue Heading&lt;/h1&gt;

&lt;!-- Alignment --&gt;
&lt;h2 style="text-align: center;"&gt;Centered Heading&lt;/h2&gt;

&lt;!-- Font Family --&gt;
&lt;h3 style="font-family: Arial, sans-serif;"&gt;Arial Heading&lt;/h3&gt;

&lt;!-- Multiple Styles --&gt;
&lt;h1 style="color: #333; text-align: center; font-size: 48px;"&gt;
    Styled Heading
&lt;/h1&gt;</code></pre>

<h3>Remember</h3>
<p>While you can style headings, always choose the heading level based on structure, not appearance. Use:</p>
<ul>
<li>h1 for main titles</li>
<li>h2 for major sections</li>
<li>h3 for subsections</li>
<li>And so on...</li>
</ul>

<p>Then apply CSS to achieve the desired visual appearance.</p>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        // Add code example
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Heading Hierarchy Practice',
            'description' => 'Create a well-structured document with proper heading hierarchy',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Heading Practice</title>
</head>
<body>
    <!-- Create a properly structured document about a topic of your choice -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Complete Guide to Web Development</title>
</head>
<body>
    <h1>Complete Guide to Web Development</h1>
    
    <h2>Frontend Development</h2>
    
    <h3>HTML - Structure</h3>
    <p>HTML provides the basic structure of websites.</p>
    <h4>Basic Elements</h4>
    <p>Learn about tags, attributes, and elements.</p>
    <h4>Advanced Features</h4>
    <p>Forms, multimedia, and semantic HTML5.</p>
    
    <h3>CSS - Styling</h3>
    <p>CSS controls the visual presentation.</p>
    <h4>Selectors and Properties</h4>
    <p>Target elements and apply styles.</p>
    <h4>Layout Techniques</h4>
    <p>Flexbox, Grid, and positioning.</p>
    
    <h3>JavaScript - Behavior</h3>
    <p>JavaScript adds interactivity to websites.</p>
    
    <h2>Backend Development</h2>
    
    <h3>Server-Side Languages</h3>
    <h4>Node.js</h4>
    <p>JavaScript on the server.</p>
    <h4>Python</h4>
    <p>Popular for web frameworks like Django.</p>
    
    <h3>Databases</h3>
    <h4>SQL Databases</h4>
    <p>Relational databases like MySQL and PostgreSQL.</p>
    <h4>NoSQL Databases</h4>
    <p>Document stores like MongoDB.</p>
</body>
</html>',
            'hints' => 'Create a well-structured document with:
1. One h1 as the main title
2. Multiple h2 sections
3. h3 subsections under each h2
4. Some h4 elements for detailed topics
5. Proper hierarchy (no skipped levels)
6. Meaningful content structure',
            'order_index' => 1,
        ]);

        // Add activity
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Create a Technical Documentation Page',
            'description' => 'Build a technical documentation page with proper heading hierarchy',
            'activity_type' => 'coding',
            'instructions' => '<h3>Build Technical Documentation</h3>
<p>Create a technical documentation page for a programming language or technology with proper heading structure.</p>

<h3>Requirements</h3>
<ul>
<li>One main h1 title for the documentation</li>
<li>At least 3 main sections with h2</li>
<li>Multiple subsections with h3 under each section</li>
<li>Some h4 elements for specific details</li>
<li>No skipped heading levels</li>
<li>Meaningful hierarchy that aids navigation</li>
</ul>

<h3>Include These Sections</h3>
<ul>
<li>Introduction/Overview</li>
<li>Installation/Setup</li>
<li>Basic Concepts</li>
<li>Examples or API Reference</li>
<li>Troubleshooting or FAQ</li>
</ul>',
            'metadata' => [
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Documentation</title>
</head>
<body>
    <!-- Create your technical documentation here -->
    
</body>
</html>',
                'solution_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Python Programming Language Documentation</title>
</head>
<body>
    <h1 style="color: #3776ab;">Python Programming Language Documentation</h1>
    
    <h2>Introduction to Python</h2>
    <p>Python is a high-level, interpreted programming language known for its simplicity and readability.</p>
    <h3>Why Choose Python?</h3>
    <p>Python offers numerous advantages for beginners and professionals alike.</p>
    <h4>Easy to Learn</h4>
    <p>Clear syntax that resembles natural language.</p>
    <h4>Versatile Applications</h4>
    <p>Web development, data science, AI, and more.</p>
    
    <h2>Installation and Setup</h2>
    <h3>System Requirements</h3>
    <p>Python runs on Windows, macOS, and Linux.</p>
    <h4>Minimum Requirements</h4>
    <p>At least 100MB of disk space and 512MB RAM.</p>
    
    <h3>Installation Steps</h3>
    <h4>Windows Installation</h4>
    <p>Download the installer from python.org and run it.</p>
    <h4>macOS Installation</h4>
    <p>Use Homebrew or download from python.org.</p>
    <h4>Linux Installation</h4>
    <p>Usually pre-installed, or use package manager.</p>
    
    <h2>Basic Concepts</h2>
    <h3>Variables and Data Types</h3>
    <h4>Numbers</h4>
    <p>Integers, floats, and complex numbers.</p>
    <h4>Strings</h4>
    <p>Text data enclosed in quotes.</p>
    <h4>Lists and Tuples</h4>
    <p>Ordered collections of items.</p>
    
    <h3>Control Flow</h3>
    <h4>If Statements</h4>
    <p>Conditional execution of code blocks.</p>
    <h4>Loops</h4>
    <p>For loops and while loops for repetition.</p>
    
    <h2>Code Examples</h2>
    <h3>Hello World</h3>
    <p>The classic first program in Python.</p>
    
    <h3>Working with Functions</h3>
    <h4>Defining Functions</h4>
    <p>Create reusable blocks of code.</p>
    <h4>Function Parameters</h4>
    <p>Pass data to functions.</p>
    
    <h2>Troubleshooting</h2>
    <h3>Common Errors</h3>
    <h4>SyntaxError</h4>
    <p>Check for typos and proper indentation.</p>
    <h4>NameError</h4>
    <p>Variable or function not defined.</p>
    
    <h3>Getting Help</h3>
    <p>Resources for learning and problem-solving.</p>
</body>
</html>',
                'validation_criteria' => [
                    [
                        'description' => 'Has exactly one h1',
                        'test_type' => 'count',
                        'expected' => '<h1',
                        'exact_count' => 1,
                        'points' => 15
                    ],
                    [
                        'description' => 'Has multiple h2 sections',
                        'test_type' => 'count',
                        'expected' => '<h2',
                        'min_count' => 3,
                        'points' => 15
                    ],
                    [
                        'description' => 'Has h3 subsections',
                        'test_type' => 'count',
                        'expected' => '<h3',
                        'min_count' => 4,
                        'points' => 20
                    ],
                    [
                        'description' => 'Includes h4 elements',
                        'test_type' => 'count',
                        'expected' => '<h4',
                        'min_count' => 2,
                        'points' => 15
                    ],
                    [
                        'description' => 'Proper hierarchy maintained',
                        'test_type' => 'heading_hierarchy',
                        'expected' => true,
                        'points' => 25
                    ],
                    [
                        'description' => 'Has descriptive content',
                        'test_type' => 'count',
                        'expected' => '<p',
                        'min_count' => 5,
                        'points' => 10
                    ]
                ],
                'hints' => [
                    'Start with a single h1 for the main title',
                    'Use h2 for major sections like Introduction, Installation, etc.',
                    'Add h3 for subsections within each major section',
                    'Use h4 for specific details or subcategories',
                    'Make sure not to skip levels (e.g., h2 to h4)'
                ]
            ],
            'difficulty' => 'intermediate',
            'points' => 100,
            'time_limit' => 2400,
            'order_index' => 1,
        ]);

        echo "HTML Headings lesson created successfully!\n";
    }
    
    private function createHTMLParagraphsLesson($htmlCourse)
    {
        $lesson = Lesson::create([
            'course_id' => $htmlCourse->id,
            'title' => 'HTML Paragraphs',
            'slug' => 'html-paragraphs',
            'description' => 'Learn to create and format paragraphs, line breaks, and preformatted text',
            'content' => '<h2>HTML Paragraphs</h2><p>Paragraphs are the building blocks of web content. Learn how to create well-formatted text that\'s easy to read.</p>',
            'lesson_type' => 'text',
            'duration_minutes' => 15,
            'is_published' => true,
            'order_index' => 7,
        ]);

        // Add topics
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Creating Paragraphs',
            'content' => '<h3>The Paragraph Element</h3>
<p>The HTML <code>&lt;p&gt;</code> element defines a paragraph. A paragraph always starts on a new line, and browsers automatically add some white space (margin) before and after a paragraph.</p>

<pre><code>&lt;p&gt;This is a paragraph.&lt;/p&gt;
&lt;p&gt;This is another paragraph.&lt;/p&gt;</code></pre>

<h3>Key Characteristics</h3>
<ul>
<li>Block-level element (takes full width)</li>
<li>Starts on a new line</li>
<li>Has margin before and after by default</li>
<li>Groups related sentences together</li>
</ul>

<h3>Best Practices</h3>
<ul>
<li>Keep paragraphs focused on one idea</li>
<li>Use multiple paragraphs for better readability</li>
<li>Don\'t use empty paragraphs for spacing (use CSS instead)</li>
<li>Always close the paragraph tag</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Display Behavior',
            'content' => '<h3>How Browsers Handle White Space</h3>
<p>You cannot be sure how HTML will be displayed. Large or small screens, and resized windows will create different results.</p>

<p>With HTML, you cannot change the display by adding extra spaces or extra lines in your HTML code. The browser will automatically remove any extra spaces and lines when the page is displayed:</p>

<pre><code>&lt;p&gt;
This paragraph
contains a lot of lines
in the source code,
but the browser
ignores it.
&lt;/p&gt;

&lt;p&gt;
This paragraph
contains         a lot of spaces
in the source         code,
but the        browser
ignores it.
&lt;/p&gt;</code></pre>

<h3>The Result</h3>
<p>Both paragraphs above will display as single lines with normal spacing, regardless of how they\'re formatted in the source code.</p>

<h3>Why This Happens</h3>
<ul>
<li>HTML collapses multiple spaces into one</li>
<li>Line breaks in code are ignored</li>
<li>This allows flexible code formatting</li>
<li>Consistent display across browsers</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Horizontal Rules and Line Breaks',
            'content' => '<h3>Horizontal Rules</h3>
<p>The <code>&lt;hr&gt;</code> tag defines a thematic break in an HTML page, and is most often displayed as a horizontal rule.</p>

<p>The <code>&lt;hr&gt;</code> element is used to separate content (or define a change) in an HTML page:</p>

<pre><code>&lt;h1&gt;Chapter 1&lt;/h1&gt;
&lt;p&gt;This is the first chapter.&lt;/p&gt;
&lt;hr&gt;
&lt;h2&gt;Chapter 2&lt;/h2&gt;
&lt;p&gt;This is the second chapter.&lt;/p&gt;
&lt;hr&gt;</code></pre>

<h3>Key Points about &lt;hr&gt;</h3>
<ul>
<li>Empty tag (no closing tag)</li>
<li>Creates a horizontal line by default</li>
<li>Can be styled with CSS</li>
<li>Semantic meaning: thematic break</li>
</ul>

<h3>Line Breaks</h3>
<p>The HTML <code>&lt;br&gt;</code> element defines a line break. Use <code>&lt;br&gt;</code> if you want a line break (a new line) without starting a new paragraph:</p>

<pre><code>&lt;p&gt;This is&lt;br&gt;a paragraph&lt;br&gt;with line breaks.&lt;/p&gt;</code></pre>

<h3>When to Use Line Breaks</h3>
<ul>
<li>Poetry or addresses</li>
<li>Where line breaks are significant</li>
<li>Not for general spacing (use CSS)</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'The Pre Element',
            'content' => '<h3>Preformatted Text</h3>
<p>The HTML <code>&lt;pre&gt;</code> element defines preformatted text. Text inside a <code>&lt;pre&gt;</code> element is displayed in a fixed-width font (usually Courier), and it preserves both spaces and line breaks:</p>

<pre><code>&lt;pre&gt;
  My Bonnie lies over the ocean.

  My Bonnie lies over the sea.

  My Bonnie lies over the ocean.

  Oh, bring back my Bonnie to me.
&lt;/pre&gt;</code></pre>

<h3>Common Uses for &lt;pre&gt;</h3>
<ul>
<li>Displaying code snippets</li>
<li>ASCII art</li>
<li>Poetry with specific formatting</li>
<li>Tabular data without tables</li>
<li>Any text where whitespace matters</li>
</ul>

<h3>&lt;pre&gt; vs Regular Text</h3>
<table border="1">
<tr>
    <th>Feature</th>
    <th>Regular Text</th>
    <th>&lt;pre&gt; Text</th>
</tr>
<tr>
    <td>Font</td>
    <td>Variable width</td>
    <td>Fixed width (monospace)</td>
</tr>
<tr>
    <td>Spaces</td>
    <td>Collapsed</td>
    <td>Preserved</td>
</tr>
<tr>
    <td>Line breaks</td>
    <td>Ignored</td>
    <td>Preserved</td>
</tr>
<tr>
    <td>Wrapping</td>
    <td>Automatic</td>
    <td>No wrap by default</td>
</tr>
</table>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        // Add code example
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Paragraph Formatting Practice',
            'description' => 'Practice creating well-formatted text with paragraphs, breaks, and preformatted sections',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Text Formatting</title>
</head>
<body>
    <!-- Create formatted text content here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Poetry and Code Examples</title>
</head>
<body>
    <h1>Text Formatting Examples</h1>
    
    <h2>Regular Paragraphs</h2>
    <p>This is the first paragraph of regular text. It demonstrates how normal paragraph formatting works in HTML.</p>
    <p>This is the second paragraph. Notice how it starts on a new line with spacing between paragraphs automatically added by the browser.</p>
    
    <hr>
    
    <h2>Address with Line Breaks</h2>
    <p>
        John Smith<br>
        123 Main Street<br>
        Apartment 4B<br>
        New York, NY 10001<br>
        USA
    </p>
    
    <hr>
    
    <h2>Poetry with Preformatted Text</h2>
    <pre>
    Two roads diverged in a yellow wood,
    And sorry I could not travel both
    And be one traveler, long I stood
    And looked down one as far as I could
    To where it bent in the undergrowth;
    
    Then took the other, as just as fair,
    And having perhaps the better claim,
    Because it was grassy and wanted wear;
    </pre>
    
    <hr>
    
    <h2>Code Example</h2>
    <p>Here\'s how to write a simple Python function:</p>
    <pre>
def greet(name):
    """This function greets someone"""
    print(f"Hello, {name}!")
    return True

# Call the function
greet("World")
    </pre>
    
    <p>The preformatted text preserves the code indentation, which is crucial for Python.</p>
</body>
</html>',
            'hints' => 'Create a page that demonstrates different text formatting:
1. Multiple regular paragraphs
2. Use of horizontal rules to separate sections
3. An address or contact info with line breaks
4. A poem or code snippet in preformatted text
5. Proper use of spacing and formatting',
            'order_index' => 1,
        ]);

        // Add activity
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Create a Blog Post Layout',
            'description' => 'Build a blog post with proper paragraph formatting and text structure',
            'activity_type' => 'coding',
            'hints' => '<h3>Create a Blog Post</h3>
<p>Build a complete blog post demonstrating mastery of text formatting elements.</p>

<h3>Requirements</h3>
<ul>
<li>Blog post title (h1)</li>
<li>Author info with line breaks</li>
<li>At least 4 content paragraphs</li>
<li>A blockquote or preformatted section</li>
<li>Horizontal rules between major sections</li>
<li>A code example in pre tags</li>
</ul>

<h3>Must Include</h3>
<ul>
<li>Introduction paragraph</li>
<li>Main content with multiple paragraphs</li>
<li>Code snippet or example</li>
<li>Conclusion paragraph</li>
<li>Author bio at the end</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Blog Post</title>
</head>
<body>
    <!-- Create your blog post here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Understanding Web Development - Tech Blog</title>
</head>
<body>
    <h1>Getting Started with Web Development in 2024</h1>
    
    <p>
        By Sarah Johnson<br>
        Senior Web Developer<br>
        Published: March 15, 2024<br>
        Reading time: 5 minutes
    </p>
    
    <hr>
    
    <h2>Introduction</h2>
    <p>Web development has evolved significantly over the past decade. What once required complex server setups and extensive configuration can now be accomplished with modern tools and frameworks. In this post, we\'ll explore the essential skills needed to start your web development journey in 2024.</p>
    
    <p>Whether you\'re a complete beginner or transitioning from another field, this guide will help you understand the fundamental concepts and technologies that power the modern web.</p>
    
    <hr>
    
    <h2>The Three Pillars of Web Development</h2>
    <p>Every website, from simple blogs to complex web applications, is built on three core technologies. Understanding these fundamentals is crucial for any aspiring web developer.</p>
    
    <h3>HTML - The Structure</h3>
    <p>HTML (HyperText Markup Language) provides the structural foundation of web pages. It defines the content and its semantic meaning - paragraphs, headings, images, links, and more. Think of HTML as the skeleton of your website.</p>
    
    <h3>CSS - The Style</h3>
    <p>CSS (Cascading Style Sheets) controls the visual presentation of HTML elements. It determines colors, fonts, layouts, and responsive behavior. CSS transforms the basic HTML structure into visually appealing designs.</p>
    
    <h3>JavaScript - The Behavior</h3>
    <p>JavaScript adds interactivity and dynamic behavior to websites. From simple animations to complex application logic, JavaScript brings web pages to life.</p>
    
    <hr>
    
    <h2>Your First HTML Page</h2>
    <p>Let\'s start with a simple example. Here\'s the basic structure of an HTML page:</p>
    
    <pre>
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;title&gt;My First Web Page&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Hello, World!&lt;/h1&gt;
    &lt;p&gt;Welcome to web development.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
    </pre>
    
    <p>This simple structure forms the foundation of every web page. The DOCTYPE declaration tells browsers we\'re using HTML5, while the head section contains metadata and the body contains visible content.</p>
    
    <hr>
    
    <h2>Next Steps</h2>
    <p>Once you\'re comfortable with HTML basics, the next steps in your journey include learning CSS for styling, understanding responsive design principles, and eventually adding JavaScript for interactivity.</p>
    
    <p>Remember, web development is a continuous learning process. Technologies evolve, new tools emerge, and best practices change. The key is to build a strong foundation and stay curious.</p>
    
    <hr>
    
    <h3>About the Author</h3>
    <p>
        Sarah Johnson is a senior web developer with over 10 years of experience building web applications.<br>
        She specializes in frontend development and loves teaching others.<br>
        Connect with her on Twitter: @sarahcodes<br>
        Website: www.sarahwebdev.com
    </p>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'Has main heading (h1)',
                    'test_type' => 'regex',
                    'expected' => '<h1>.*?</h1>',
                    'points' => 10
                ],
                [
                    'description' => 'Uses line breaks for author info',
                    'test_type' => 'count',
                    'expected' => '<br>',
                    'min_count' => 2,
                    'points' => 15
                ],
                [
                    'description' => 'Has multiple paragraphs',
                    'test_type' => 'count',
                    'expected' => '<p>',
                    'min_count' => 4,
                    'points' => 20
                ],
                [
                    'description' => 'Uses horizontal rules',
                    'test_type' => 'count',
                    'expected' => '<hr>',
                    'min_count' => 2,
                    'points' => 15
                ],
                [
                    'description' => 'Contains preformatted text',
                    'test_type' => 'regex',
                    'expected' => '<pre>.*?</pre>',
                    'points' => 20
                ],
                [
                    'description' => 'Well-structured content',
                    'test_type' => 'content_length',
                    'expected' => '1000',
                    'points' => 20
                ]
            ],
            'hints' => [
                'Use br tags for line breaks in addresses or author info',
                'Separate major sections with hr tags',
                'Use pre tags for code examples to preserve formatting',
                'Write meaningful content in your paragraphs',
                'Consider the logical flow of your blog post'
            ],
            'difficulty' => 'intermediate',
            'points' => 100,
            'time_limit' => 3000,
            'order_index' => 1,
        ]);

        echo "HTML Paragraphs lesson created successfully!\n";
    }
    
    private function createHTMLStylesLesson($htmlCourse)
    {
        $lesson = Lesson::create([
            'course_id' => $htmlCourse->id,
            'title' => 'HTML Styles',
            'slug' => 'html-styles',
            'description' => 'Learn how to apply CSS styles to HTML elements using the style attribute',
            'content' => '<h2>HTML Styles</h2><p>The HTML style attribute is used to add styles to an element, such as color, font, size, and more. While external CSS is preferred, inline styles are useful for quick styling.</p>',
            'lesson_type' => 'text',
            'duration_minutes' => 20,
            'is_published' => true,
            'order_index' => 8,
        ]);

        // Add topics
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'The HTML Style Attribute',
            'content' => '<h3>Introduction to Inline Styles</h3>
<p>The HTML <code>style</code> attribute is used to add styles directly to an element. This method is called inline styling.</p>

<h3>Basic Syntax</h3>
<pre><code>&lt;tagname style="property:value;"&gt;Content&lt;/tagname&gt;</code></pre>

<p>The <strong>property</strong> is a CSS property. The <strong>value</strong> is a CSS value.</p>

<h3>Multiple Style Properties</h3>
<p>You can add multiple CSS properties by separating them with semicolons:</p>
<pre><code>&lt;p style="color:red; font-size:20px; text-align:center;"&gt;
    Styled paragraph
&lt;/p&gt;</code></pre>

<h3>When to Use Inline Styles</h3>
<ul>
<li>Quick testing and prototyping</li>
<li>Unique styles for a single element</li>
<li>Dynamic styles generated by JavaScript</li>
<li>Email HTML (where external CSS is limited)</li>
</ul>

<h3>Limitations</h3>
<ul>
<li>Cannot be reused across multiple elements</li>
<li>Makes HTML harder to maintain</li>
<li>Mixes presentation with content</li>
<li>Overrides external stylesheets</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Background Color',
            'content' => '<h3>Setting Background Colors</h3>
<p>The CSS <code>background-color</code> property defines the background color for an HTML element.</p>

<h3>Page Background</h3>
<pre><code>&lt;body style="background-color:powderblue;"&gt;
    &lt;h1&gt;This is a heading&lt;/h1&gt;
    &lt;p&gt;This is a paragraph.&lt;/p&gt;
&lt;/body&gt;</code></pre>

<h3>Element Backgrounds</h3>
<pre><code>&lt;h1 style="background-color:tomato;"&gt;Tomato Background&lt;/h1&gt;
&lt;p style="background-color:lightgray;"&gt;Gray Background&lt;/p&gt;
&lt;div style="background-color:yellow;"&gt;Yellow Box&lt;/div&gt;</code></pre>

<h3>Color Values</h3>
<p>You can specify colors in several ways:</p>
<ul>
<li><strong>Color names:</strong> red, blue, tomato, lightgray</li>
<li><strong>Hex codes:</strong> #FF0000, #0000FF, #FF6347</li>
<li><strong>RGB values:</strong> rgb(255, 0, 0), rgb(0, 0, 255)</li>
<li><strong>RGBA (with transparency):</strong> rgba(255, 0, 0, 0.5)</li>
</ul>

<pre><code>&lt;p style="background-color:red;"&gt;Color name&lt;/p&gt;
&lt;p style="background-color:#FF0000;"&gt;Hex code&lt;/p&gt;
&lt;p style="background-color:rgb(255,0,0);"&gt;RGB value&lt;/p&gt;
&lt;p style="background-color:rgba(255,0,0,0.5);"&gt;50% transparent red&lt;/p&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Text Color and Font Styles',
            'content' => '<h3>Text Color</h3>
<p>The CSS <code>color</code> property defines the text color for an HTML element:</p>

<pre><code>&lt;h1 style="color:blue;"&gt;Blue Heading&lt;/h1&gt;
&lt;p style="color:red;"&gt;Red paragraph text&lt;/p&gt;
&lt;p style="color:#009900;"&gt;Green text using hex&lt;/p&gt;</code></pre>

<h3>Font Family</h3>
<p>The CSS <code>font-family</code> property defines the font to be used:</p>

<pre><code>&lt;h1 style="font-family:verdana;"&gt;Verdana Font&lt;/h1&gt;
&lt;p style="font-family:courier;"&gt;Courier Font (monospace)&lt;/p&gt;
&lt;p style="font-family:\'Times New Roman\', serif;"&gt;Times Font&lt;/p&gt;</code></pre>

<h3>Font Stacks</h3>
<p>Specify multiple fonts as fallbacks:</p>
<pre><code>&lt;p style="font-family: Arial, Helvetica, sans-serif;"&gt;
    This will use Arial, or Helvetica if Arial is not available
&lt;/p&gt;</code></pre>

<h3>Generic Font Families</h3>
<ul>
<li><strong>serif</strong> - Times New Roman, Georgia</li>
<li><strong>sans-serif</strong> - Arial, Helvetica</li>
<li><strong>monospace</strong> - Courier, Consolas</li>
<li><strong>cursive</strong> - Comic Sans MS</li>
<li><strong>fantasy</strong> - Impact</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Text Size',
            'content' => '<h3>Font Size Property</h3>
<p>The CSS <code>font-size</code> property defines the text size for an HTML element:</p>

<pre><code>&lt;h1 style="font-size:60px;"&gt;60px Heading&lt;/h1&gt;
&lt;p style="font-size:20px;"&gt;20px paragraph&lt;/p&gt;
&lt;p style="font-size:14px;"&gt;14px paragraph&lt;/p&gt;</code></pre>

<h3>Size Units</h3>
<p>Different units for specifying font size:</p>

<h4>Absolute Units</h4>
<ul>
<li><strong>px</strong> - pixels (most common)</li>
<li><strong>pt</strong> - points (1pt = 1/72 inch)</li>
</ul>

<h4>Relative Units</h4>
<ul>
<li><strong>em</strong> - relative to parent font size</li>
<li><strong>rem</strong> - relative to root font size</li>
<li><strong>%</strong> - percentage of parent size</li>
<li><strong>vw</strong> - viewport width</li>
</ul>

<pre><code>&lt;p style="font-size:16px;"&gt;16 pixels&lt;/p&gt;
&lt;p style="font-size:1.5em;"&gt;1.5 times parent size&lt;/p&gt;
&lt;p style="font-size:120%;"&gt;120% of parent size&lt;/p&gt;
&lt;p style="font-size:2rem;"&gt;2 times root size&lt;/p&gt;
&lt;h1 style="font-size:5vw;"&gt;Responsive to viewport&lt;/h1&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Text Alignment',
            'content' => '<h3>Horizontal Text Alignment</h3>
<p>The CSS <code>text-align</code> property defines the horizontal text alignment for an HTML element:</p>

<pre><code>&lt;h1 style="text-align:center;"&gt;Centered Heading&lt;/h1&gt;
&lt;p style="text-align:left;"&gt;Left aligned paragraph (default)&lt;/p&gt;
&lt;p style="text-align:right;"&gt;Right aligned paragraph&lt;/p&gt;
&lt;p style="text-align:justify;"&gt;Justified text spreads evenly...&lt;/p&gt;</code></pre>

<h3>Alignment Values</h3>
<ul>
<li><strong>left</strong> - Default alignment</li>
<li><strong>center</strong> - Centers the text</li>
<li><strong>right</strong> - Right-aligns the text</li>
<li><strong>justify</strong> - Stretches lines to equal width</li>
</ul>

<h3>Combining Multiple Styles</h3>
<p>You can combine multiple CSS properties for comprehensive styling:</p>

<pre><code>&lt;h1 style="
    color: navy;
    font-family: Arial, sans-serif;
    font-size: 36px;
    text-align: center;
    background-color: lightyellow;
    padding: 20px;
"&gt;
    Fully Styled Heading
&lt;/h1&gt;</code></pre>

<h3>Best Practice Tip</h3>
<p>While inline styles work, it\'s better to use external CSS files for maintainability. Use inline styles only for:</p>
<ul>
<li>Quick tests</li>
<li>Unique, one-time styles</li>
<li>Dynamically generated styles</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 5,
        ]);

        // Add code example
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Style Attribute Practice',
            'description' => 'Practice applying various inline styles to HTML elements',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Style Practice</title>
</head>
<body>
    <!-- Apply styles to these elements -->
    <h1>Welcome to My Styled Page</h1>
    
    <p>This paragraph needs styling.</p>
    
    <div>
        <h2>Section Title</h2>
        <p>Section content goes here.</p>
    </div>
    
    <p>Final paragraph</p>
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Style Practice</title>
</head>
<body style="background-color: #f0f8ff;">
    <h1 style="color: #2c3e50; text-align: center; font-size: 48px; font-family: Georgia, serif;">
        Welcome to My Styled Page
    </h1>
    
    <p style="color: #34495e; font-size: 18px; text-align: justify; margin: 20px 50px;">
        This paragraph needs styling. It now has custom color, size, alignment, and margins.
    </p>
    
    <div style="background-color: #e8f4f8; padding: 20px; border-radius: 10px;">
        <h2 style="color: #16a085; font-family: Arial, sans-serif; font-size: 32px;">
            Section Title
        </h2>
        <p style="color: #7f8c8d; font-size: 16px; line-height: 1.6;">
            Section content goes here with improved readability through line height.
        </p>
    </div>
    
    <p style="text-align: center; color: #e74c3c; font-size: 20px; font-weight: bold; margin-top: 30px;">
        Final paragraph with bold red text
    </p>
</body>
</html>',
            'hints' => 'Apply various inline styles to create an attractive page:
1. Set a light background color for the body
2. Style the h1 with color, center alignment, and custom font
3. Give the first paragraph justified alignment and custom margins
4. Create a styled container div with background and padding
5. Apply different colors and fonts to different elements
6. Make the final paragraph centered and bold',
            'order_index' => 1,
        ]);

        // Add activity
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Create a Styled Business Card',
            'description' => 'Design a digital business card using inline styles',
            'activity_type' => 'coding',
            'hints' => '<h3>Design a Digital Business Card</h3>
<p>Create a professional-looking business card using only HTML and inline styles.</p>

<h3>Requirements</h3>
<ul>
<li>Card container with background color and padding</li>
<li>Name as main heading (styled prominently)</li>
<li>Job title with different styling</li>
<li>Contact information section</li>
<li>At least 5 different CSS properties used</li>
<li>Professional color scheme</li>
</ul>

<h3>Must Include Styling For</h3>
<ul>
<li>Background colors (body and card)</li>
<li>Text colors and sizes</li>
<li>Font families</li>
<li>Text alignment</li>
<li>Spacing (padding/margins)</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Business Card</title>
</head>
<body>
    <!-- Create your styled business card here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Digital Business Card - Jane Doe</title>
</head>
<body style="background-color: #ecf0f1; font-family: Arial, sans-serif; padding: 50px;">
    <div style="background-color: #ffffff; max-width: 500px; margin: 0 auto; padding: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 10px;">
        
        <h1 style="color: #2c3e50; font-size: 36px; text-align: center; margin: 0; font-family: Georgia, serif;">
            Jane Doe
        </h1>
        
        <p style="color: #3498db; font-size: 20px; text-align: center; margin: 10px 0 30px 0; font-weight: 300;">
            Senior Web Developer
        </p>
        
        <hr style="border: none; border-top: 2px solid #bdc3c7; margin: 30px 0;">
        
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px;">
            <h2 style="color: #7f8c8d; font-size: 18px; margin: 0 0 15px 0; text-transform: uppercase; letter-spacing: 1px;">
                Contact Information
            </h2>
            
            <p style="color: #34495e; font-size: 16px; margin: 8px 0;">
                <span style="font-weight: bold; color: #95a5a6;">Email:</span> 
                <span style="color: #3498db;">jane.doe@techcorp.com</span>
            </p>
            
            <p style="color: #34495e; font-size: 16px; margin: 8px 0;">
                <span style="font-weight: bold; color: #95a5a6;">Phone:</span> 
                (555) 123-4567
            </p>
            
            <p style="color: #34495e; font-size: 16px; margin: 8px 0;">
                <span style="font-weight: bold; color: #95a5a6;">LinkedIn:</span> 
                <span style="color: #3498db;">linkedin.com/in/janedoe</span>
            </p>
            
            <p style="color: #34495e; font-size: 16px; margin: 8px 0;">
                <span style="font-weight: bold; color: #95a5a6;">Website:</span> 
                <span style="color: #3498db;">www.janedoe.dev</span>
            </p>
        </div>
        
        <p style="text-align: center; color: #95a5a6; font-size: 14px; margin-top: 30px; font-style: italic;">
            "Creating elegant solutions for complex problems"
        </p>
        
        <div style="text-align: center; margin-top: 20px;">
            <span style="background-color: #3498db; color: white; padding: 5px 10px; margin: 0 5px; font-size: 12px; border-radius: 3px;">HTML</span>
            <span style="background-color: #9b59b6; color: white; padding: 5px 10px; margin: 0 5px; font-size: 12px; border-radius: 3px;">CSS</span>
            <span style="background-color: #e74c3c; color: white; padding: 5px 10px; margin: 0 5px; font-size: 12px; border-radius: 3px;">JavaScript</span>
            <span style="background-color: #2ecc71; color: white; padding: 5px 10px; margin: 0 5px; font-size: 12px; border-radius: 3px;">React</span>
        </div>
    </div>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'Has styled body background',
                    'test_type' => 'regex',
                    'expected' => '<body[^>]+style=.*?background-color',
                    'points' => 10
                ],
                [
                    'description' => 'Main heading is styled',
                    'test_type' => 'regex',
                    'expected' => '<h1[^>]+style=.*?(color|font-size)',
                    'points' => 15
                ],
                [
                    'description' => 'Uses multiple font properties',
                    'test_type' => 'count',
                    'expected' => 'font-',
                    'min_count' => 3,
                    'points' => 15
                ],
                [
                    'description' => 'Uses text alignment',
                    'test_type' => 'regex',
                    'expected' => 'text-align:',
                    'points' => 10
                ],
                [
                    'description' => 'Multiple background colors used',
                    'test_type' => 'count',
                    'expected' => 'background-color:',
                    'min_count' => 2,
                    'points' => 15
                ],
                [
                    'description' => 'Uses padding or margin',
                    'test_type' => 'regex',
                    'expected' => '(padding:|margin:)',
                    'points' => 15
                ],
                [
                    'description' => 'Professional appearance',
                    'test_type' => 'style_count',
                    'expected' => '15',
                    'points' => 20
                ]
            ],
            'hints' => [
                'Start with a styled body background',
                'Create a card container with padding and background',
                'Use different font sizes for hierarchy',
                'Consider using hr for visual separation',
                'Professional colors: blues, grays, whites'
            ],
            'difficulty' => 'intermediate',
            'points' => 100,
            'time_limit' => 3600,
            'order_index' => 1,
        ]);

        echo "HTML Styles lesson created successfully!\n";
    }
    
    private function createHTMLFormattingLesson($htmlCourse)
    {
        $lesson = Lesson::create([
            'course_id' => $htmlCourse->id,
            'title' => 'HTML Text Formatting',
            'slug' => 'html-formatting',
            'description' => 'Learn HTML formatting elements for bold, italic, and other text styles',
            'content' => '<h2>HTML Text Formatting</h2><p>HTML contains several elements for defining text with special meaning. These formatting elements allow you to emphasize, highlight, and style text semantically.</p>',
            'lesson_type' => 'text',
            'duration_minutes' => 20,
            'is_published' => true,
            'order_index' => 9,
        ]);

        // Add topics
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Formatting Elements',
            'content' => '<h3>Text with Special Meaning</h3>
<p>HTML formatting elements were designed to display special types of text with semantic meaning:</p>

<ul>
<li><code>&lt;b&gt;</code> - Bold text</li>
<li><code>&lt;strong&gt;</code> - Important text</li>
<li><code>&lt;i&gt;</code> - Italic text</li>
<li><code>&lt;em&gt;</code> - Emphasized text</li>
<li><code>&lt;mark&gt;</code> - Marked/highlighted text</li>
<li><code>&lt;small&gt;</code> - Smaller text</li>
<li><code>&lt;del&gt;</code> - Deleted text</li>
<li><code>&lt;ins&gt;</code> - Inserted text</li>
<li><code>&lt;sub&gt;</code> - Subscript text</li>
<li><code>&lt;sup&gt;</code> - Superscript text</li>
</ul>

<h3>Semantic vs Presentational</h3>
<p>These elements carry meaning beyond just visual appearance. Screen readers and search engines understand their purpose, making your content more accessible and meaningful.</p>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Bold and Strong Elements',
            'content' => '<h3>The &lt;b&gt; Element</h3>
<p>The HTML <code>&lt;b&gt;</code> element defines bold text, without any extra importance:</p>

<pre><code>&lt;p&gt;This is normal text - &lt;b&gt;and this is bold text&lt;/b&gt;.&lt;/p&gt;</code></pre>

<h3>The &lt;strong&gt; Element</h3>
<p>The HTML <code>&lt;strong&gt;</code> element defines text with strong importance. The content inside is typically displayed in bold:</p>

<pre><code>&lt;p&gt;&lt;strong&gt;Warning!&lt;/strong&gt; This action cannot be undone.&lt;/p&gt;
&lt;p&gt;It is &lt;strong&gt;very important&lt;/strong&gt; to follow the instructions.&lt;/p&gt;</code></pre>

<h3>When to Use Which?</h3>
<table border="1">
<tr>
    <th>Use &lt;b&gt;</th>
    <th>Use &lt;strong&gt;</th>
</tr>
<tr>
    <td>Keywords in a summary</td>
    <td>Warnings or cautions</td>
</tr>
<tr>
    <td>Product names in reviews</td>
    <td>Very important text</td>
</tr>
<tr>
    <td>Visual emphasis only</td>
    <td>Semantic importance</td>
</tr>
</table>

<p><strong>Note:</strong> Screen readers may announce &lt;strong&gt; content with different intonation to convey importance.</p>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Italic and Emphasized Elements',
            'content' => '<h3>The &lt;i&gt; Element</h3>
<p>The HTML <code>&lt;i&gt;</code> element defines a part of text in an alternate voice or mood. The content inside is typically displayed in italic:</p>

<pre><code>&lt;p&gt;The ship &lt;i&gt;Titanic&lt;/i&gt; sank in 1912.&lt;/p&gt;
&lt;p&gt;The word &lt;i&gt;café&lt;/i&gt; comes from French.&lt;/p&gt;</code></pre>

<h3>Common Uses for &lt;i&gt;</h3>
<ul>
<li>Technical terms</li>
<li>Foreign language phrases</li>
<li>Thoughts (in narratives)</li>
<li>Ship or vehicle names</li>
<li>Book or movie titles</li>
</ul>

<h3>The &lt;em&gt; Element</h3>
<p>The HTML <code>&lt;em&gt;</code> element defines emphasized text. The content inside is typically displayed in italic:</p>

<pre><code>&lt;p&gt;We &lt;em&gt;cannot&lt;/em&gt; afford to be late!&lt;/p&gt;
&lt;p&gt;I &lt;em&gt;love&lt;/em&gt; what you\'ve done with the place.&lt;/p&gt;</code></pre>

<h3>The Difference</h3>
<ul>
<li><strong>&lt;i&gt;</strong>: Alternative voice/mood without emphasis</li>
<li><strong>&lt;em&gt;</strong>: Stress emphasis that changes meaning</li>
</ul>

<p><strong>Tip:</strong> Screen readers will pronounce &lt;em&gt; content with verbal stress.</p>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Small, Mark, Del, and Ins Elements',
            'content' => '<h3>The &lt;small&gt; Element</h3>
<p>The HTML <code>&lt;small&gt;</code> element defines smaller text:</p>

<pre><code>&lt;h2&gt;HTML &lt;small&gt;Formatting&lt;/small&gt; Elements&lt;/h2&gt;
&lt;p&gt;&lt;small&gt;Copyright © 2024 Example Corp.&lt;/small&gt;&lt;/p&gt;</code></pre>

<h3>The &lt;mark&gt; Element</h3>
<p>The HTML <code>&lt;mark&gt;</code> element defines text that should be marked or highlighted:</p>

<pre><code>&lt;p&gt;Search results for "html": 
The &lt;mark&gt;HTML&lt;/mark&gt; standard defines web structure.&lt;/p&gt;</code></pre>

<h3>The &lt;del&gt; Element</h3>
<p>The HTML <code>&lt;del&gt;</code> element defines text that has been deleted from a document. Browsers usually strike through deleted text:</p>

<pre><code>&lt;p&gt;My favorite color is &lt;del&gt;blue&lt;/del&gt; red.&lt;/p&gt;
&lt;p&gt;Price: &lt;del&gt;$50&lt;/del&gt; $30 (Save 40%!)&lt;/p&gt;</code></pre>

<h3>The &lt;ins&gt; Element</h3>
<p>The HTML <code>&lt;ins&gt;</code> element defines text that has been inserted into a document. Browsers usually underline inserted text:</p>

<pre><code>&lt;p&gt;My favorite color is &lt;del&gt;blue&lt;/del&gt; &lt;ins&gt;red&lt;/ins&gt;.&lt;/p&gt;
&lt;p&gt;The meeting is on &lt;del&gt;Monday&lt;/del&gt; &lt;ins&gt;Tuesday&lt;/ins&gt;.&lt;/p&gt;</code></pre>

<h3>Practical Uses</h3>
<ul>
<li><strong>&lt;small&gt;:</strong> Fine print, copyright notices, side comments</li>
<li><strong>&lt;mark&gt;:</strong> Search results, important passages, current relevance</li>
<li><strong>&lt;del&gt;/&lt;ins&gt;:</strong> Document revisions, price changes, corrections</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Subscript and Superscript',
            'content' => '<h3>The &lt;sub&gt; Element</h3>
<p>The HTML <code>&lt;sub&gt;</code> element defines subscript text. Subscript text appears half a character below the normal line, and is sometimes rendered in smaller font:</p>

<pre><code>&lt;p&gt;Water formula: H&lt;sub&gt;2&lt;/sub&gt;O&lt;/p&gt;
&lt;p&gt;Footnote reference&lt;sub&gt;1&lt;/sub&gt;&lt;/p&gt;
&lt;p&gt;Chemical formula: C&lt;sub&gt;6&lt;/sub&gt;H&lt;sub&gt;12&lt;/sub&gt;O&lt;sub&gt;6&lt;/sub&gt;&lt;/p&gt;</code></pre>

<h3>The &lt;sup&gt; Element</h3>
<p>The HTML <code>&lt;sup&gt;</code> element defines superscript text. Superscript text appears half a character above the normal line, and is sometimes rendered in smaller font:</p>

<pre><code>&lt;p&gt;Today is the 21&lt;sup&gt;st&lt;/sup&gt; century&lt;/p&gt;
&lt;p&gt;E = mc&lt;sup&gt;2&lt;/sup&gt;&lt;/p&gt;
&lt;p&gt;Reference&lt;sup&gt;[1]&lt;/sup&gt;&lt;/p&gt;</code></pre>

<h3>Common Uses</h3>
<h4>Subscript (&lt;sub&gt;)</h4>
<ul>
<li>Chemical formulas (H₂SO₄)</li>
<li>Mathematical subscripts (X₁, X₂)</li>
<li>Footnote markers</li>
</ul>

<h4>Superscript (&lt;sup&gt;)</h4>
<ul>
<li>Exponents (2³ = 8)</li>
<li>Ordinal numbers (1st, 2nd, 3rd)</li>
<li>Footnote/citation markers [¹]</li>
<li>Trademark symbols (™)</li>
</ul>

<h3>Complete Example</h3>
<pre><code>&lt;p&gt;
    The area of a circle is A = πr&lt;sup&gt;2&lt;/sup&gt;, 
    where H&lt;sub&gt;2&lt;/sub&gt;O represents water.
    This was discovered in the 18&lt;sup&gt;th&lt;/sup&gt; century&lt;sup&gt;[2]&lt;/sup&gt;.
&lt;/p&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 5,
        ]);

        // Add code example
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Text Formatting Practice',
            'description' => 'Practice using all HTML text formatting elements',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Formatting Practice</title>
</head>
<body>
    <h1>Text Formatting Examples</h1>
    
    <!-- Add various formatting to this content -->
    <p>This paragraph needs various formatting applied to demonstrate all the different HTML formatting elements we\'ve learned.</p>
    
    <p>Water is H2O and energy equals mc2.</p>
    
    <p>The price was $100 but now it\'s $75!</p>
    
    <p>This is a very important warning message.</p>
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Formatting Practice</title>
</head>
<body>
    <h1>Text Formatting Examples</h1>
    
    <p>This paragraph has <b>bold text</b>, <i>italic text</i>, <strong>important text</strong>, 
    and <em>emphasized text</em>. We can also <mark>highlight important parts</mark> 
    and show <small>smaller text for fine print</small>.</p>
    
    <p>Water is H<sub>2</sub>O and energy equals mc<sup>2</sup>.</p>
    
    <p>The price was <del>$100</del> but now it\'s <ins>$75</ins>! 
    <strong>Limited time offer!</strong></p>
    
    <p><strong>Warning:</strong> This is a <em>very</em> important 
    <mark>warning message</mark>.</p>
    
    <h2>Scientific Notation</h2>
    <p>The speed of light is 3.0 × 10<sup>8</sup> m/s</p>
    <p>Carbon dioxide is CO<sub>2</sub></p>
    
    <h2>Literary Example</h2>
    <p>She thought to herself, <i>What a beautiful day!</i> as she read 
    <i>Pride and Prejudice</i> for the <del>second</del> <ins>third</ins> time.</p>
    
    <p><small>Copyright<sup>©</sup> 2024. All rights reserved.</small></p>
</body>
</html>',
            'hints' => 'Apply appropriate formatting elements:
1. Use bold and strong appropriately
2. Add italic and emphasized text
3. Include subscript for chemical formulas
4. Add superscript for exponents
5. Show deleted and inserted text
6. Highlight text with mark
7. Add small text for copyright',
            'order_index' => 1,
        ]);

        // Add activity
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Create a Scientific Article',
            'description' => 'Build a scientific article demonstrating all text formatting elements',
            'activity_type' => 'coding',
            'hints' => '<h3>Create a Scientific Article</h3>
<p>Write a short scientific article that uses all the HTML formatting elements appropriately.</p>

<h3>Requirements</h3>
<ul>
<li>Article about a scientific topic</li>
<li>Use subscript for chemical formulas</li>
<li>Use superscript for exponents and citations</li>
<li>Bold/strong for important terms</li>
<li>Italic/em for emphasis and scientific names</li>
<li>Mark element for key findings</li>
<li>Del/ins for corrections or updates</li>
<li>Small text for footnotes or disclaimers</li>
</ul>

<h3>Must Include</h3>
<ul>
<li>At least one chemical formula</li>
<li>Mathematical equation with exponents</li>
<li>Scientific names in italics</li>
<li>Highlighted important discoveries</li>
<li>Citation references</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Scientific Article</title>
</head>
<body>
    <!-- Create your scientific article here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>The Role of Photosynthesis in Climate Change</title>
</head>
<body>
    <h1>The Role of Photosynthesis in Climate Change</h1>
    <p><small>Published: March 2024 | Dr. Sarah Chen<sup>[1]</sup></small></p>
    
    <h2>Abstract</h2>
    <p>Recent studies have shown that <mark>photosynthesis plays a crucial role in regulating atmospheric CO<sub>2</sub> levels</mark>. 
    This article examines the relationship between plant photosynthesis and global climate patterns.</p>
    
    <h2>Introduction</h2>
    <p>Photosynthesis is the process by which plants convert carbon dioxide (CO<sub>2</sub>) and water (H<sub>2</sub>O) 
    into glucose (C<sub>6</sub>H<sub>12</sub>O<sub>6</sub>) and oxygen (O<sub>2</sub>). The <strong>overall equation</strong> is:</p>
    
    <p style="text-align: center;">
        6CO<sub>2</sub> + 6H<sub>2</sub>O + light energy → C<sub>6</sub>H<sub>12</sub>O<sub>6</sub> + 6O<sub>2</sub>
    </p>
    
    <h2>Key Findings</h2>
    <p>Our research indicates that <em>Quercus robur</em> (common oak) can absorb approximately 
    <del>20 kg</del> <ins>22 kg</ins> of CO<sub>2</sub> per year<sup>[2]</sup>. This is <mark>10% higher than previously estimated</mark>.</p>
    
    <p>The rate of photosynthesis follows the equation: <b>P = k × I × C</b>, where:</p>
    <ul>
        <li><b>P</b> = photosynthetic rate</li>
        <li><b>I</b> = light intensity (measured in μmol m<sup>-2</sup> s<sup>-1</sup>)</li>
        <li><b>C</b> = CO<sub>2</sub> concentration</li>
        <li><b>k</b> = rate constant</li>
    </ul>
    
    <h2>Climate Impact</h2>
    <p><strong>Important:</strong> Trees can reduce local temperatures by up to 2<sup>°</sup>C through 
    transpiration<sup>[3]</sup>. The Amazon rainforest alone produces <em>approximately</em> 20% of Earth\'s oxygen.</p>
    
    <p>Recent measurements show atmospheric CO<sub>2</sub> levels at 420 ppm<sup>[4]</sup>, which is 
    <mark>50% higher than pre-industrial levels</mark> of 280 ppm.</p>
    
    <h2>Conclusion</h2>
    <p>Understanding photosynthesis is <strong>critical</strong> for addressing climate change. 
    As we\'ve seen, even <small>small changes in photosynthetic rates</small> can have 
    <em>significant impacts</em> on global CO<sub>2</sub> levels.</p>
    
    <hr>
    <p><small>
        <sup>[1]</sup> Department of Biology, Climate University<br>
        <sup>[2]</sup> Chen et al., <i>Journal of Plant Science</i>, 2024<br>
        <sup>[3]</sup> Global Climate Report, 2023<br>
        <sup>[4]</sup> NOAA Climate Data, March 2024<br>
        <br>
        <i>Disclaimer: This is a simplified example for educational purposes.</i>
    </small></p>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'Uses subscript for formulas',
                    'test_type' => 'count',
                    'expected' => '<sub>',
                    'min_count' => 4,
                    'points' => 15
                ],
                [
                    'description' => 'Uses superscript',
                    'test_type' => 'count',
                    'expected' => '<sup>',
                    'min_count' => 3,
                    'points' => 15
                ],
                [
                    'description' => 'Contains bold/strong text',
                    'test_type' => 'regex',
                    'expected' => '<(b|strong)>.*?</(b|strong)>',
                    'points' => 10
                ],
                [
                    'description' => 'Contains italic/em text',
                    'test_type' => 'regex',
                    'expected' => '<(i|em)>.*?</(i|em)>',
                    'points' => 10
                ],
                [
                    'description' => 'Uses mark for highlighting',
                    'test_type' => 'regex',
                    'expected' => '<mark>.*?</mark>',
                    'points' => 15
                ],
                [
                    'description' => 'Shows edits with del/ins',
                    'test_type' => 'regex',
                    'expected' => '<del>.*?</del>.*?<ins>.*?</ins>',
                    'points' => 15
                ],
                [
                    'description' => 'Uses small text',
                    'test_type' => 'regex',
                    'expected' => '<small>.*?</small>',
                    'points' => 10
                ],
                [
                    'description' => 'Scientific accuracy',
                    'test_type' => 'content_check',
                    'expected' => 'scientific',
                    'points' => 10
                ]
            ],
            'hints' => [
                'Use subscript for chemical formulas like H2O',
                'Use superscript for citations and exponents',
                'Italicize scientific names (genus species)',
                'Use mark to highlight key findings',
                'Show corrections with del and ins tags'
            ],
            'difficulty' => 'advanced',
            'points' => 100,
            'time_limit' => 3600,
            'order_index' => 1,
        ]);

        echo "HTML Formatting lesson created successfully!\n";
    }
}

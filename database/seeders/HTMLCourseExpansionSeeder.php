<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use App\Models\Activity;
use App\Models\CodeExample;

class HTMLCourseExpansionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the HTML course
        $htmlCourse = Course::where('slug', 'html5-tutorial')->first();
        
        if (!$htmlCourse) {
            echo "HTML course not found!\n";
            return;
        }

        // Part 1: Update HTML Editors Lesson
        $this->updateHTMLEditorsLesson($htmlCourse);
        
        // Part 2: Update HTML Basic Lesson  
        $this->updateHTMLBasicLesson($htmlCourse);
        
        // Part 3: Create new lessons
        $this->createNewLessons($htmlCourse);
    }

    private function updateHTMLEditorsLesson($htmlCourse)
    {
        $lesson = Lesson::where('course_id', $htmlCourse->id)
                       ->where('slug', 'html-editors')
                       ->first();
                       
        if (!$lesson) {
            echo "HTML Editors lesson not found!\n";
            return;
        }

        // Update lesson content
        $lesson->update([
            'content' => '<h2>HTML Editors</h2><p>A simple text editor is all you need to learn HTML.</p><h3>Learn HTML Using Notepad or TextEdit</h3><p>Web pages can be created and modified by using professional HTML editors. However, for learning HTML we recommend a simple text editor like Notepad (PC) or TextEdit (Mac).</p><p>We believe that using a simple text editor is a good way to learn HTML.</p>',
            'description' => 'Learn how to create HTML files using simple text editors and view them in your browser',
        ]);

        // Clear existing topics
        $lesson->topics()->delete();

        // Add new topics
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Getting Started with Text Editors',
            'content' => '<p>To start writing HTML, you need a text editor. While there are many professional HTML editors available, we recommend starting with a simple text editor to focus on learning the code itself.</p>

<h4>Step 1: Open Your Text Editor</h4>

<h5>For Windows Users (Notepad):</h5>
<p><strong>Windows 8 or later:</strong> Open the Start Screen (the window symbol at the bottom left on your screen). Type "Notepad" and select it.</p>
<p><strong>Windows 7 or earlier:</strong> Open Start > Programs > Accessories > Notepad</p>

<h5>For Mac Users (TextEdit):</h5>
<p>Open Finder > Applications > TextEdit</p>
<p><strong>Important for Mac users:</strong> You need to change some preferences to work with HTML properly:</p>
<ul>
<li>In Preferences > Format > choose "Plain Text"</li>
<li>Under "Open and Save", check the box that says "Display HTML files as HTML code instead of formatted text"</li>
</ul>
<p>After setting preferences, open a new document to start coding.</p>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Writing Your First HTML',
            'content' => '<h4>Step 2: Write Your HTML Code</h4>
<p>Type or copy the following HTML code into your text editor:</p>

<pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;body&gt;

&lt;h1&gt;My First Heading&lt;/h1&gt;

&lt;p&gt;My first paragraph.&lt;/p&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>

<p>This is the basic structure of every HTML page. Let\'s understand what each part does:</p>
<ul>
<li><code>&lt;!DOCTYPE html&gt;</code> - Tells the browser this is an HTML5 document</li>
<li><code>&lt;html&gt;</code> - The root element that contains all other elements</li>
<li><code>&lt;body&gt;</code> - Contains the visible content of the page</li>
<li><code>&lt;h1&gt;</code> - Creates a main heading</li>
<li><code>&lt;p&gt;</code> - Creates a paragraph</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Saving and Viewing HTML Files',
            'content' => '<h4>Step 3: Save Your HTML File</h4>
<p>After writing your HTML code, you need to save it properly:</p>
<ol>
<li>Select <strong>File > Save as</strong> in your text editor</li>
<li>Name the file "index.html" (or any name ending with .html or .htm)</li>
<li>Set the encoding to <strong>UTF-8</strong> (the standard encoding for HTML files)</li>
<li>Save it to a location you can easily find (like your Desktop)</li>
</ol>

<p><strong>💡 Tip:</strong> You can use either .htm or .html as the file extension. There\'s no difference - it\'s entirely your choice!</p>

<h4>Step 4: View Your HTML Page in a Browser</h4>
<p>To see your HTML page in action:</p>
<ol>
<li>Find the saved HTML file on your computer</li>
<li>Double-click the file, OR</li>
<li>Right-click and choose "Open with" then select your favorite browser</li>
</ol>

<p>The browser will display your HTML page, showing the heading and paragraph you created!</p>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Online HTML Editors',
            'content' => '<h3>Try It Yourself with Online Editors</h3>
<p>While learning with a simple text editor is great, online HTML editors offer some advantages:</p>
<ul>
<li>No need to save files</li>
<li>Instant preview of your changes</li>
<li>Color-coded syntax highlighting</li>
<li>Easy sharing with others</li>
</ul>

<p>Popular online HTML editors include:</p>
<ul>
<li>CodePen</li>
<li>JSFiddle</li>
<li>CodeSandbox</li>
<li>Repl.it</li>
</ul>

<p>These tools are perfect when you want to quickly test code or share examples with others.</p>

<h3>Building Your Own Website</h3>
<p>Once you\'re comfortable with HTML, you might want to create your own website and host it online. There are many free and paid options available for hosting your HTML files on the internet.</p>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        // Add code example for this lesson
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Complete HTML Template',
            'description' => 'A full HTML template you can use as a starting point',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>My Web Page</title>
</head>
<body>
    <h1>Welcome to My Website</h1>
    <p>This is my first web page!</p>
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>My Amazing Website</title>
</head>
<body>
    <h1>Welcome to My Amazing Website</h1>
    <h2>About Me</h2>
    <p>Hi! I\'m learning HTML and loving it!</p>
    <h2>My Hobbies</h2>
    <p>I enjoy coding and creating websites.</p>
</body>
</html>',
            'instructions' => 'Modify this template to create your own web page. Try adding:
- A more descriptive title
- Additional headings using <h2> tags
- More paragraphs about yourself
- Different content that interests you',
            'order_index' => 1,
        ]);

        // Add activity for HTML Editors lesson
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Create Your Personal Web Page',
            'description' => 'Use a text editor to create a complete HTML page about yourself',
            'activity_type' => 'coding',
            'instructions' => '<h3>Your Task</h3>
<p>Create a personal web page using your text editor that includes:</p>
<ol>
<li>A proper HTML document structure with DOCTYPE, html, head, and body tags</li>
<li>A meaningful page title in the head section</li>
<li>At least 3 different headings (h1, h2, h3)</li>
<li>At least 3 paragraphs of content about yourself</li>
<li>Save it as "about-me.html"</li>
</ol>

<h3>Requirements</h3>
<ul>
<li>Use proper HTML5 structure</li>
<li>Include a title tag in the head</li>
<li>Use semantic heading hierarchy (h1 for main title, h2 for sections, etc.)</li>
<li>Write meaningful content (at least 50 words total)</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <!-- Add your page title here -->
</head>
<body>
    <!-- Create your personal web page here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>About John Doe - Personal Portfolio</title>
</head>
<body>
    <h1>John Doe - Web Developer in Training</h1>
    
    <h2>About Me</h2>
    <p>Hello! I\'m John Doe, an aspiring web developer currently learning HTML. I\'m passionate about creating beautiful and functional websites that make a difference in people\'s lives.</p>
    
    <h2>My Journey</h2>
    <p>I started learning web development recently and I\'m amazed by how much you can create with just HTML! Every day I\'m discovering new tags and techniques that help me build better web pages.</p>
    
    <h3>Current Focus</h3>
    <p>Right now, I\'m focusing on mastering HTML fundamentals. Once I\'m comfortable with HTML, I plan to learn CSS to make my pages look amazing, and then JavaScript to add interactivity.</p>
    
    <h2>Goals</h2>
    <p>My goal is to become a full-stack web developer and create applications that solve real-world problems. I believe that technology can make the world a better place, and I want to be part of that change.</p>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'DOCTYPE declaration present',
                    'test_type' => 'contains',
                    'expected' => '<!DOCTYPE html>',
                    'points' => 10
                ],
                [
                    'description' => 'Has title tag in head',
                    'test_type' => 'regex',
                    'expected' => '<head>.*?<title>.*?</title>.*?</head>',
                    'points' => 15
                ],
                [
                    'description' => 'Contains h1 heading',
                    'test_type' => 'regex',
                    'expected' => '<h1>.*?</h1>',
                    'points' => 15
                ],
                [
                    'description' => 'Contains h2 headings',
                    'test_type' => 'regex',
                    'expected' => '<h2>.*?</h2>',
                    'points' => 15
                ],
                [
                    'description' => 'Contains at least 3 paragraphs',
                    'test_type' => 'count',
                    'expected' => '<p>',
                    'min_count' => 3,
                    'points' => 20
                ],
                [
                    'description' => 'Proper HTML structure',
                    'test_type' => 'structure',
                    'expected' => 'html,head,body',
                    'points' => 25
                ]
            ],
            'hints' => [
                'Remember to include the DOCTYPE declaration at the very beginning',
                'The title tag goes inside the head section',
                'Use h1 for your main heading, h2 for sections, and h3 for subsections',
                'Each paragraph should be wrapped in <p> tags'
            ],
            'difficulty' => 'beginner',
            'points' => 100,
            'time_limit' => 1800,
            'order_index' => 1,
        ]);

        echo "HTML Editors lesson updated successfully!\n";
    }

    private function updateHTMLBasicLesson($htmlCourse)
    {
        $lesson = Lesson::where('course_id', $htmlCourse->id)
                       ->where('slug', 'html-basic')
                       ->first();
                       
        if (!$lesson) {
            echo "HTML Basic lesson not found!\n";
            return;
        }

        // Update lesson content
        $lesson->update([
            'content' => '<h2>HTML Basic Examples</h2><p>In this chapter we will show some basic HTML examples to help you understand the fundamentals.</p>',
            'description' => 'Learn the basic HTML structure, headings, paragraphs, links, and images',
        ]);

        // Clear existing topics
        $lesson->topics()->delete();

        // Add new topics for HTML Basic
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Documents',
            'content' => '<p>Every HTML document has a standard structure that browsers expect. Understanding this structure is crucial for creating valid web pages.</p>

<h3>Basic HTML Document Structure</h3>
<p>All HTML documents must start with a document type declaration: <code>&lt;!DOCTYPE html&gt;</code>.</p>
<p>The HTML document itself begins with <code>&lt;html&gt;</code> and ends with <code>&lt;/html&gt;</code>.</p>
<p>The visible part of the HTML document is between <code>&lt;body&gt;</code> and <code>&lt;/body&gt;</code>.</p>

<pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;body&gt;

&lt;h1&gt;My First Heading&lt;/h1&gt;
&lt;p&gt;My first paragraph.&lt;/p&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>

<h3>The DOCTYPE Declaration</h3>
<p>The <code>&lt;!DOCTYPE&gt;</code> declaration represents the document type, and helps browsers to display web pages correctly.</p>
<ul>
<li>It must only appear once, at the top of the page (before any HTML tags)</li>
<li>The DOCTYPE declaration is not case sensitive</li>
<li>For HTML5, the declaration is simply: <code>&lt;!DOCTYPE html&gt;</code></li>
</ul>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Headings',
            'content' => '<h3>Understanding HTML Headings</h3>
<p>HTML headings are defined with the <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code> tags.</p>
<p><code>&lt;h1&gt;</code> defines the most important heading. <code>&lt;h6&gt;</code> defines the least important heading.</p>

<pre><code>&lt;h1&gt;This is heading 1&lt;/h1&gt;
&lt;h2&gt;This is heading 2&lt;/h2&gt;
&lt;h3&gt;This is heading 3&lt;/h3&gt;
&lt;h4&gt;This is heading 4&lt;/h4&gt;
&lt;h5&gt;This is heading 5&lt;/h5&gt;
&lt;h6&gt;This is heading 6&lt;/h6&gt;</code></pre>

<h3>Why Headings Matter</h3>
<ul>
<li>Search engines use headings to index the structure and content of your web pages</li>
<li>Users skim pages by reading headings</li>
<li>Screen readers use headings to help visually impaired users navigate</li>
<li>Proper heading hierarchy improves accessibility</li>
</ul>

<p><strong>Best Practice:</strong> Use only one <code>&lt;h1&gt;</code> per page - it should represent the main topic or purpose of the entire page.</p>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Paragraphs',
            'content' => '<h3>Creating Paragraphs</h3>
<p>HTML paragraphs are defined with the <code>&lt;p&gt;</code> tag:</p>

<pre><code>&lt;p&gt;This is a paragraph.&lt;/p&gt;
&lt;p&gt;This is another paragraph.&lt;/p&gt;</code></pre>

<h3>Important Points about Paragraphs</h3>
<ul>
<li>Browsers automatically add space (margin) before and after paragraphs</li>
<li>Multiple spaces and line breaks in your code are ignored</li>
<li>Each paragraph starts on a new line</li>
<li>The closing tag <code>&lt;/p&gt;</code> is required</li>
</ul>

<h3>Line Breaks</h3>
<p>If you want a line break without starting a new paragraph, use the <code>&lt;br&gt;</code> tag:</p>
<pre><code>&lt;p&gt;This is&lt;br&gt;a paragraph&lt;br&gt;with line breaks.&lt;/p&gt;</code></pre>

<p>The <code>&lt;br&gt;</code> tag is an empty tag, which means it has no closing tag.</p>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Links',
            'content' => '<h3>Creating Links</h3>
<p>HTML links are defined with the <code>&lt;a&gt;</code> tag (anchor tag):</p>

<pre><code>&lt;a href="https://www.example.com"&gt;This is a link&lt;/a&gt;</code></pre>

<h3>The href Attribute</h3>
<p>The link\'s destination is specified in the <code>href</code> attribute. This attribute is required for the link to work.</p>

<h3>Types of Links</h3>
<ul>
<li><strong>External links:</strong> Links to other websites<br>
<code>&lt;a href="https://www.google.com"&gt;Visit Google&lt;/a&gt;</code></li>
<li><strong>Internal links:</strong> Links to pages on the same website<br>
<code>&lt;a href="about.html"&gt;About Us&lt;/a&gt;</code></li>
<li><strong>Email links:</strong> Opens the user\'s email program<br>
<code>&lt;a href="mailto:someone@example.com"&gt;Send Email&lt;/a&gt;</code></li>
<li><strong>Anchor links:</strong> Links to sections within the same page<br>
<code>&lt;a href="#section1"&gt;Go to Section 1&lt;/a&gt;</code></li>
</ul>

<p><strong>Note:</strong> Attributes provide additional information about HTML elements. You\'ll learn more about attributes in upcoming lessons.</p>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Images',
            'content' => '<h3>Displaying Images</h3>
<p>HTML images are defined with the <code>&lt;img&gt;</code> tag.</p>
<p>The source file (<code>src</code>), alternative text (<code>alt</code>), <code>width</code>, and <code>height</code> are provided as attributes:</p>

<pre><code>&lt;img src="image.jpg" alt="Description" width="500" height="300"&gt;</code></pre>

<h3>Required Attributes</h3>
<ul>
<li><strong>src:</strong> Specifies the path to the image file</li>
<li><strong>alt:</strong> Provides alternative text if the image cannot be displayed</li>
</ul>

<h3>Optional but Recommended Attributes</h3>
<ul>
<li><strong>width:</strong> Specifies the width of the image in pixels</li>
<li><strong>height:</strong> Specifies the height of the image in pixels</li>
</ul>

<h3>Image File Paths</h3>
<ul>
<li><strong>Relative path:</strong> <code>src="images/photo.jpg"</code> (image in a folder)</li>
<li><strong>Root relative:</strong> <code>src="/images/photo.jpg"</code> (from website root)</li>
<li><strong>Absolute URL:</strong> <code>src="https://example.com/photo.jpg"</code> (external image)</li>
</ul>

<p><strong>Note:</strong> The <code>&lt;img&gt;</code> tag is an empty tag (no closing tag needed).</p>',
            'content_type' => 'text',
            'order_index' => 5,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Viewing HTML Source Code',
            'content' => '<h3>How to View HTML Source</h3>
<p>Have you ever seen a web page and wondered "How did they do that?" You can easily view the HTML source code of any web page!</p>

<h3>View Full Page Source</h3>
<p>To see the complete HTML source code of a page:</p>
<ul>
<li><strong>Keyboard shortcut:</strong> Press <kbd>Ctrl+U</kbd> (Windows) or <kbd>Cmd+Option+U</kbd> (Mac)</li>
<li><strong>Right-click method:</strong> Right-click on the page and select "View Page Source"</li>
</ul>
<p>This opens a new tab showing all the HTML code for that page.</p>

<h3>Inspect Specific Elements</h3>
<p>To examine individual elements:</p>
<ol>
<li>Right-click on any element on the page</li>
<li>Select "Inspect" or "Inspect Element"</li>
<li>The Developer Tools will open, showing:
    <ul>
    <li>The HTML structure</li>
    <li>CSS styles applied to the element</li>
    <li>The ability to edit code live (changes are temporary)</li>
    </ul>
</li>
</ol>

<h3>Why View Source Code?</h3>
<ul>
<li>Learn from other websites</li>
<li>Debug your own pages</li>
<li>Understand how certain effects are achieved</li>
<li>See the structure behind complex layouts</li>
</ul>

<p><strong>Tip:</strong> The Inspector tool is one of the most valuable resources for web developers!</p>',
            'content_type' => 'text',
            'order_index' => 6,
        ]);

        // Add code examples for HTML Basic lesson
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Complete HTML Page Example',
            'description' => 'A full HTML page demonstrating all basic elements',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<body>

    <!-- Add your content here -->

</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>My First Complete Web Page</title>
</head>
<body>
    <h1>Welcome to My Website</h1>
    
    <h2>About This Page</h2>
    <p>This is a complete HTML page with all the basic elements we\'ve learned.</p>
    
    <h2>What I\'ve Learned</h2>
    <p>I can now create headings, paragraphs, links, and add images to my web pages!</p>
    
    <h3>Useful Resources</h3>
    <p>Check out these helpful websites:</p>
    <a href="https://developer.mozilla.org">MDN Web Docs</a>
    <br>
    <a href="https://www.w3.org">W3C Standards</a>
    
    <h3>My Favorite Image</h3>
    <img src="https://via.placeholder.com/300x200" alt="Placeholder image" width="300" height="200">
    
    <p>Thanks for visiting my page!</p>
</body>
</html>',
            'instructions' => 'Create a complete HTML page that includes:
1. A proper DOCTYPE and HTML structure
2. A meaningful page title
3. Multiple headings (h1, h2, h3)
4. Several paragraphs
5. At least 2 links
6. At least 1 image with proper attributes',
            'order_index' => 1,
        ]);

        // Add activity for HTML Basic lesson
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Build a Recipe Page',
            'description' => 'Create a complete HTML page for your favorite recipe using all the basic elements',
            'activity_type' => 'coding',
            'instructions' => '<h3>Create a Recipe Web Page</h3>
<p>Build a web page for your favorite recipe that includes all the HTML elements we\'ve learned.</p>

<h3>Requirements</h3>
<ul>
<li>Proper HTML5 document structure</li>
<li>Descriptive page title (in the head)</li>
<li>Main heading (h1) with the recipe name</li>
<li>Section headings (h2) for Ingredients and Instructions</li>
<li>Subheadings (h3) if needed</li>
<li>Paragraphs for the recipe description</li>
<li>At least one image of the dish</li>
<li>A link to a related recipe or cooking website</li>
</ul>

<h3>Bonus Points</h3>
<ul>
<li>Add nutritional information</li>
<li>Include cooking time and servings</li>
<li>Add links to ingredient suppliers</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <!-- Add your recipe title here -->
</head>
<body>
    <!-- Build your recipe page here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Classic Chocolate Chip Cookies Recipe</title>
</head>
<body>
    <h1>Classic Chocolate Chip Cookies</h1>
    
    <p>These homemade chocolate chip cookies are soft, chewy, and absolutely delicious! This recipe has been passed down through generations and never fails to impress.</p>
    
    <img src="https://via.placeholder.com/400x300" alt="Delicious chocolate chip cookies" width="400" height="300">
    
    <h2>Recipe Information</h2>
    <p>Prep Time: 15 minutes<br>
    Cook Time: 12 minutes<br>
    Total Time: 27 minutes<br>
    Servings: 24 cookies</p>
    
    <h2>Ingredients</h2>
    <p>Gather these ingredients to make the perfect cookies:</p>
    <h3>Dry Ingredients</h3>
    <p>2¼ cups all-purpose flour<br>
    1 tsp baking soda<br>
    1 tsp salt</p>
    
    <h3>Wet Ingredients</h3>
    <p>1 cup butter, softened<br>
    ¾ cup granulated sugar<br>
    ¾ cup packed brown sugar<br>
    2 large eggs<br>
    2 tsp vanilla extract</p>
    
    <h3>Mix-ins</h3>
    <p>2 cups chocolate chips</p>
    
    <h2>Instructions</h2>
    <h3>Step 1: Prepare</h3>
    <p>Preheat your oven to 375°F (190°C). Line baking sheets with parchment paper.</p>
    
    <h3>Step 2: Mix Dry Ingredients</h3>
    <p>In a medium bowl, whisk together the flour, baking soda, and salt. Set aside.</p>
    
    <h3>Step 3: Cream Butter and Sugars</h3>
    <p>In a large bowl, beat the softened butter with both sugars until light and fluffy, about 3-4 minutes.</p>
    
    <h3>Step 4: Add Eggs and Vanilla</h3>
    <p>Beat in eggs one at a time, then stir in the vanilla extract.</p>
    
    <h3>Step 5: Combine and Fold</h3>
    <p>Gradually blend in the flour mixture. Fold in the chocolate chips.</p>
    
    <h3>Step 6: Bake</h3>
    <p>Drop rounded tablespoons of dough onto prepared baking sheets. Bake for 10-12 minutes until golden brown. Cool on baking sheet for 2 minutes before transferring to a wire rack.</p>
    
    <h2>Tips for Success</h2>
    <p>For the best results, chill your dough for 30 minutes before baking. This helps prevent spreading and creates a chewier texture!</p>
    
    <p>Want more delicious recipes? Check out <a href="https://www.allrecipes.com">AllRecipes</a> for inspiration!</p>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'Has proper DOCTYPE',
                    'test_type' => 'contains',
                    'expected' => '<!DOCTYPE html>',
                    'points' => 10
                ],
                [
                    'description' => 'Has title in head',
                    'test_type' => 'regex',
                    'expected' => '<head>.*?<title>.*?recipe.*?</title>.*?</head>',
                    'points' => 10
                ],
                [
                    'description' => 'Contains h1 heading',
                    'test_type' => 'regex',
                    'expected' => '<h1>.*?</h1>',
                    'points' => 10
                ],
                [
                    'description' => 'Contains h2 headings for sections',
                    'test_type' => 'count',
                    'expected' => '<h2>',
                    'min_count' => 2,
                    'points' => 15
                ],
                [
                    'description' => 'Contains paragraphs',
                    'test_type' => 'count',
                    'expected' => '<p>',
                    'min_count' => 3,
                    'points' => 15
                ],
                [
                    'description' => 'Contains at least one image',
                    'test_type' => 'regex',
                    'expected' => '<img[^>]+src=.*?alt=.*?>',
                    'points' => 20
                ],
                [
                    'description' => 'Contains at least one link',
                    'test_type' => 'regex',
                    'expected' => '<a[^>]+href=.*?>.*?</a>',
                    'points' => 20
                ]
            ],
            'hints' => [
                'Start with the basic HTML structure',
                'Use h1 for the recipe name',
                'Use h2 for major sections like Ingredients and Instructions',
                'Don\'t forget the alt attribute for images',
                'Make sure your links have href attributes'
            ],
            'difficulty' => 'beginner',
            'points' => 100,
            'time_limit' => 2400,
            'order_index' => 1,
        ]);

        echo "HTML Basic lesson updated successfully!\n";
    }

    private function createNewLessons($htmlCourse)
    {
        // Create HTML Elements lesson
        $this->createHTMLElementsLesson($htmlCourse);
        
        // Create HTML Attributes lesson
        $this->createHTMLAttributesLesson($htmlCourse);
        
        // Create HTML Headings lesson
        $this->createHTMLHeadingsLesson($htmlCourse);
        
        // Create HTML Paragraphs lesson
        $this->createHTMLParagraphsLesson($htmlCourse);
        
        // Create HTML Styles lesson
        $this->createHTMLStylesLesson($htmlCourse);
        
        // Create HTML Formatting lesson
        $this->createHTMLFormattingLesson($htmlCourse);
    }
    
    private function createHTMLElementsLesson($htmlCourse)
    {
        $lesson = Lesson::create([
            'course_id' => $htmlCourse->id,
            'title' => 'HTML Elements',
            'slug' => 'html-elements',
            'description' => 'Learn about HTML elements, their structure, nesting, and best practices',
            'content' => '<h2>HTML Elements</h2><p>An HTML element is defined by a start tag, some content, and an end tag. Understanding elements is fundamental to writing HTML.</p>',
            'lesson_type' => 'text',
            'duration_minutes' => 15,
            'is_published' => true,
            'order_index' => 4,
        ]);

        // Add topics for HTML Elements
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'What are HTML Elements?',
            'content' => '<h3>Understanding HTML Elements</h3>
<p>The HTML element is everything from the start tag to the end tag:</p>

<pre><code>&lt;tagname&gt;Content goes here...&lt;/tagname&gt;</code></pre>

<h3>Examples of HTML Elements</h3>
<pre><code>&lt;h1&gt;My First Heading&lt;/h1&gt;
&lt;p&gt;My first paragraph.&lt;/p&gt;
&lt;div&gt;A container element&lt;/div&gt;</code></pre>

<h3>Anatomy of an HTML Element</h3>
<table border="1">
<tr>
    <th>Start tag</th>
    <th>Element content</th>
    <th>End tag</th>
</tr>
<tr>
    <td>&lt;h1&gt;</td>
    <td>My First Heading</td>
    <td>&lt;/h1&gt;</td>
</tr>
<tr>
    <td>&lt;p&gt;</td>
    <td>My first paragraph.</td>
    <td>&lt;/p&gt;</td>
</tr>
<tr>
    <td>&lt;br&gt;</td>
    <td>none</td>
    <td>none</td>
</tr>
</table>

<p><strong>Note:</strong> Some HTML elements have no content (like the &lt;br&gt; element). These elements are called empty elements. Empty elements do not have an end tag!</p>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Nested HTML Elements',
            'content' => '<h3>Elements Can Be Nested</h3>
<p>HTML elements can be nested, which means that elements can contain other elements. All HTML documents consist of nested HTML elements.</p>

<h3>Example of Nested Elements</h3>
<pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;body&gt;

&lt;h1&gt;My First Heading&lt;/h1&gt;
&lt;p&gt;My first paragraph.&lt;/p&gt;

&lt;/body&gt;
&lt;/html&gt;</code></pre>

<h3>Understanding the Nesting Structure</h3>
<ul>
<li>The <code>&lt;html&gt;</code> element is the root element and defines the whole HTML document
    <ul>
    <li>It has a start tag <code>&lt;html&gt;</code> and an end tag <code>&lt;/html&gt;</code></li>
    <li>Inside it contains a <code>&lt;body&gt;</code> element</li>
    </ul>
</li>
<li>The <code>&lt;body&gt;</code> element defines the document\'s body
    <ul>
    <li>It has a start tag <code>&lt;body&gt;</code> and an end tag <code>&lt;/body&gt;</code></li>
    <li>Inside it contains two other elements: <code>&lt;h1&gt;</code> and <code>&lt;p&gt;</code></li>
    </ul>
</li>
<li>The <code>&lt;h1&gt;</code> element defines a heading
    <ul>
    <li>It has a start tag <code>&lt;h1&gt;</code> and an end tag <code>&lt;/h1&gt;</code></li>
    </ul>
</li>
<li>The <code>&lt;p&gt;</code> element defines a paragraph
    <ul>
    <li>It has a start tag <code>&lt;p&gt;</code> and an end tag <code>&lt;/p&gt;</code></li>
    </ul>
</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Never Skip the End Tag',
            'content' => '<h3>Always Close Your Tags</h3>
<p>Some HTML elements will display correctly, even if you forget the end tag:</p>

<pre><code>&lt;html&gt;
&lt;body&gt;

&lt;p&gt;This is a paragraph
&lt;p&gt;This is another paragraph

&lt;/body&gt;
&lt;/html&gt;</code></pre>

<h3>Why This Is Dangerous</h3>
<p><strong>However, never rely on this!</strong> Unexpected results and errors may occur if you forget the end tag.</p>

<p>Problems that can occur:</p>
<ul>
<li>Layout issues when elements aren\'t properly closed</li>
<li>JavaScript may not work correctly</li>
<li>CSS styles might apply incorrectly</li>
<li>Future browsers might not support unclosed tags</li>
<li>Your HTML won\'t validate</li>
</ul>

<h3>Best Practice</h3>
<p>Always write your HTML with both opening and closing tags (except for empty elements). This ensures your code is:</p>
<ul>
<li>Valid and standards-compliant</li>
<li>Compatible with all browsers</li>
<li>Easier to debug and maintain</li>
<li>Professional and clean</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Empty HTML Elements',
            'content' => '<h3>Elements Without Content</h3>
<p>HTML elements with no content are called empty elements or void elements.</p>

<p>The <code>&lt;br&gt;</code> tag defines a line break, and is an empty element without a closing tag:</p>

<pre><code>&lt;p&gt;This is a &lt;br&gt; paragraph with a line break.&lt;/p&gt;</code></pre>

<h3>Common Empty Elements</h3>
<ul>
<li><code>&lt;br&gt;</code> - Line break</li>
<li><code>&lt;hr&gt;</code> - Horizontal rule</li>
<li><code>&lt;img&gt;</code> - Image</li>
<li><code>&lt;input&gt;</code> - Form input</li>
<li><code>&lt;link&gt;</code> - External resource link</li>
<li><code>&lt;meta&gt;</code> - Metadata</li>
<li><code>&lt;area&gt;</code> - Image map area</li>
<li><code>&lt;source&gt;</code> - Media resource</li>
</ul>

<h3>Self-Closing Tags</h3>
<p>In XHTML, empty elements must be closed with a slash before the closing bracket:</p>
<pre><code>&lt;br /&gt;
&lt;hr /&gt;
&lt;img src="image.jpg" alt="Description" /&gt;</code></pre>

<p>In HTML5, the slash is optional but adding it doesn\'t hurt and can make your code more compatible:</p>
<pre><code>&lt;br&gt; or &lt;br /&gt;
&lt;hr&gt; or &lt;hr /&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML is Not Case Sensitive',
            'content' => '<h3>Case Sensitivity in HTML</h3>
<p>HTML tags are not case sensitive: <code>&lt;P&gt;</code> means the same as <code>&lt;p&gt;</code>.</p>

<h3>Examples of Valid HTML</h3>
<p>All of these are technically valid:</p>
<pre><code>&lt;P&gt;This is a paragraph.&lt;/P&gt;
&lt;p&gt;This is a paragraph.&lt;/p&gt;
&lt;P&gt;This is a paragraph.&lt;/p&gt;</code></pre>

<h3>Best Practice: Use Lowercase</h3>
<p>The HTML standard does not require lowercase tags, but W3C <strong>recommends</strong> lowercase in HTML, and <strong>demands</strong> lowercase for stricter document types like XHTML.</p>

<h3>Why Use Lowercase?</h3>
<ul>
<li>It\'s the industry standard</li>
<li>It\'s easier to read and type</li>
<li>It\'s required for XHTML compatibility</li>
<li>Most developers expect lowercase</li>
<li>It looks more professional</li>
</ul>

<h3>Be Consistent</h3>
<p>Whatever convention you choose, be consistent throughout your document. However, we strongly recommend always using lowercase tags.</p>

<pre><code>&lt;!-- Recommended --&gt;
&lt;div&gt;
    &lt;p&gt;This is the standard way to write HTML.&lt;/p&gt;
&lt;/div&gt;

&lt;!-- Not recommended --&gt;
&lt;DIV&gt;
    &lt;P&gt;This works but is not recommended.&lt;/P&gt;
&lt;/DIV&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 5,
        ]);

        // Add code example
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'HTML Elements Practice',
            'description' => 'Practice creating properly nested HTML elements',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<body>
    <!-- Create a properly nested structure here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<body>
    <div>
        <h1>Understanding HTML Elements</h1>
        <p>This paragraph demonstrates proper nesting.</p>
        
        <div>
            <h2>Nested Elements</h2>
            <p>Elements can contain other elements, creating a tree structure.</p>
            <p>Here\'s another paragraph with a <br> line break.</p>
        </div>
        
        <hr>
        
        <div>
            <h2>Empty Elements</h2>
            <p>Some elements like br and hr don\'t have closing tags.</p>
            <img src="example.jpg" alt="Example image">
        </div>
    </div>
</body>
</html>',
            'instructions' => 'Create a properly structured HTML document that demonstrates:
1. Nested elements (divs containing other elements)
2. Proper opening and closing tags
3. At least one empty element (br, hr, or img)
4. Consistent lowercase tag names
5. Proper indentation to show nesting',
            'order_index' => 1,
        ]);

        // Add activity
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Build a Nested Navigation Menu',
            'description' => 'Create a properly nested HTML structure for a website navigation menu',
            'activity_type' => 'coding',
            'instructions' => '<h3>Create a Navigation Structure</h3>
<p>Build a navigation menu that demonstrates proper HTML element nesting and structure.</p>

<h3>Requirements</h3>
<ul>
<li>Use proper HTML5 document structure</li>
<li>Create a navigation section with nested elements</li>
<li>Include at least 3 levels of nesting</li>
<li>Use both container elements (div) and content elements (h1, p, etc.)</li>
<li>Include at least 2 empty elements</li>
<li>Use consistent lowercase tags</li>
</ul>

<h3>Structure to Include</h3>
<ul>
<li>A main navigation container</li>
<li>A site title/logo area</li>
<li>A menu list with items</li>
<li>Dropdown submenus (nested lists)</li>
<li>Proper use of semantic elements</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Navigation Menu</title>
</head>
<body>
    <!-- Create your navigation structure here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Navigation Menu</title>
</head>
<body>
    <nav>
        <div>
            <h1>My Website</h1>
            <hr>
            
            <div>
                <h2>Main Menu</h2>
                <ul>
                    <li>
                        <a href="#home">Home</a>
                    </li>
                    <li>
                        <a href="#about">About</a>
                        <ul>
                            <li><a href="#team">Our Team</a></li>
                            <li><a href="#history">Our History</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#services">Services</a>
                        <ul>
                            <li><a href="#design">Web Design</a></li>
                            <li><a href="#development">Development</a></li>
                            <li><a href="#seo">SEO</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            
            <hr>
            
            <div>
                <p>Welcome to our website!<br>
                Explore our menu above.</p>
                <img src="logo.png" alt="Company Logo">
            </div>
        </div>
    </nav>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'Has proper DOCTYPE',
                    'test_type' => 'contains',
                    'expected' => '<!DOCTYPE html>',
                    'points' => 10
                ],
                [
                    'description' => 'Contains nav element',
                    'test_type' => 'regex',
                    'expected' => '<nav>.*?</nav>',
                    'points' => 15
                ],
                [
                    'description' => 'Has nested structure (3+ levels)',
                    'test_type' => 'structure_depth',
                    'expected' => '3',
                    'points' => 20
                ],
                [
                    'description' => 'Contains unordered list',
                    'test_type' => 'regex',
                    'expected' => '<ul>.*?</ul>',
                    'points' => 15
                ],
                [
                    'description' => 'Contains list items',
                    'test_type' => 'count',
                    'expected' => '<li>',
                    'min_count' => 4,
                    'points' => 15
                ],
                [
                    'description' => 'Contains empty elements',
                    'test_type' => 'count_any',
                    'expected' => ['<br>', '<hr>', '<img'],
                    'min_count' => 2,
                    'points' => 15
                ],
                [
                    'description' => 'All tags are lowercase',
                    'test_type' => 'no_uppercase_tags',
                    'expected' => true,
                    'points' => 10
                ]
            ],
            'hints' => [
                'Start with a nav element as your main container',
                'Use ul and li elements for menu items',
                'Nest ul elements inside li elements for submenus',
                'Remember to include empty elements like hr or br',
                'Check that all your tags are lowercase'
            ],
            'difficulty' => 'beginner',
            'points' => 100,
            'time_limit' => 2400,
            'order_index' => 1,
        ]);

        echo "HTML Elements lesson created successfully!\n";
    }
    
    private function createHTMLAttributesLesson($htmlCourse)
    {
        $lesson = Lesson::create([
            'course_id' => $htmlCourse->id,
            'title' => 'HTML Attributes',
            'slug' => 'html-attributes',
            'description' => 'Learn how HTML attributes provide additional information about elements',
            'content' => '<h2>HTML Attributes</h2><p>HTML attributes provide additional information about HTML elements. They help control how elements behave and appear.</p>',
            'lesson_type' => 'text',
            'duration_minutes' => 20,
            'is_published' => true,
            'order_index' => 5,
        ]);

        // Add topics for HTML Attributes
        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Understanding HTML Attributes',
            'content' => '<h3>What Are HTML Attributes?</h3>
<p>HTML attributes provide additional information about HTML elements and control their behavior.</p>

<h3>Key Points About Attributes</h3>
<ul>
<li>All HTML elements can have attributes</li>
<li>Attributes provide additional information about elements</li>
<li>Attributes are always specified in the start tag</li>
<li>Attributes usually come in name/value pairs like: <code>name="value"</code></li>
</ul>

<h3>Basic Attribute Syntax</h3>
<pre><code>&lt;element attribute="value"&gt;Content&lt;/element&gt;

&lt;!-- Real examples --&gt;
&lt;a href="https://example.com"&gt;Link&lt;/a&gt;
&lt;img src="photo.jpg" alt="Description"&gt;
&lt;div class="container" id="main"&gt;Content&lt;/div&gt;</code></pre>

<h3>Common Attributes</h3>
<ul>
<li><strong>id:</strong> Unique identifier for an element</li>
<li><strong>class:</strong> One or more class names for styling</li>
<li><strong>style:</strong> Inline CSS styles</li>
<li><strong>title:</strong> Extra information (tooltip)</li>
</ul>',
            'content_type' => 'text',
            'order_index' => 1,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'The href Attribute',
            'content' => '<h3>Creating Links with href</h3>
<p>The <code>&lt;a&gt;</code> tag defines a hyperlink. The <code>href</code> attribute specifies the URL of the page the link goes to:</p>

<pre><code>&lt;a href="https://www.example.com"&gt;Visit Example.com&lt;/a&gt;</code></pre>

<h3>Different Types of href Values</h3>
<ul>
<li><strong>Absolute URLs:</strong> Full web address<br>
<code>&lt;a href="https://www.google.com"&gt;Google&lt;/a&gt;</code></li>

<li><strong>Relative URLs:</strong> Path relative to current page<br>
<code>&lt;a href="about.html"&gt;About Us&lt;/a&gt;</code></li>

<li><strong>Anchor links:</strong> Jump to section on same page<br>
<code>&lt;a href="#section1"&gt;Go to Section 1&lt;/a&gt;</code></li>

<li><strong>Email links:</strong> Open email client<br>
<code>&lt;a href="mailto:info@example.com"&gt;Email Us&lt;/a&gt;</code></li>

<li><strong>Tel links:</strong> Make phone calls<br>
<code>&lt;a href="tel:+1234567890"&gt;Call Us&lt;/a&gt;</code></li>
</ul>

<h3>Additional Link Attributes</h3>
<ul>
<li><code>target="_blank"</code> - Opens link in new tab/window</li>
<li><code>rel="noopener"</code> - Security best practice with target="_blank"</li>
<li><code>download</code> - Force download instead of navigation</li>
</ul>

<pre><code>&lt;a href="document.pdf" download&gt;Download PDF&lt;/a&gt;
&lt;a href="https://example.com" target="_blank" rel="noopener"&gt;Open in New Tab&lt;/a&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 2,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'The src Attribute',
            'content' => '<h3>Embedding Images with src</h3>
<p>The <code>&lt;img&gt;</code> tag is used to embed an image in an HTML page. The <code>src</code> attribute specifies the path to the image to be displayed:</p>

<pre><code>&lt;img src="image.jpg" alt="Description"&gt;</code></pre>

<h3>Types of Image URLs</h3>
<h4>1. Absolute URL</h4>
<p>Links to an external image hosted on another website:</p>
<pre><code>&lt;img src="https://www.example.com/images/photo.jpg" alt="External image"&gt;</code></pre>

<p><strong>⚠️ Important considerations for external images:</strong></p>
<ul>
<li>They might be under copyright</li>
<li>You cannot control if they\'re removed or changed</li>
<li>They require internet connection to load</li>
<li>They might slow down your page</li>
</ul>

<h4>2. Relative URL</h4>
<p>Links to an image within your website:</p>
<pre><code>&lt;!-- Image in same folder --&gt;
&lt;img src="photo.jpg" alt="Local image"&gt;

&lt;!-- Image in subfolder --&gt;
&lt;img src="images/photo.jpg" alt="Image in folder"&gt;

&lt;!-- Image from root --&gt;
&lt;img src="/images/photo.jpg" alt="Root image"&gt;</code></pre>

<p><strong>💡 Tip:</strong> It\'s almost always best to use relative URLs. They won\'t break if you change domain.</p>',
            'content_type' => 'text',
            'order_index' => 3,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Width, Height, and Alt Attributes',
            'content' => '<h3>Image Dimensions</h3>
<p>The <code>&lt;img&gt;</code> tag should also contain the <code>width</code> and <code>height</code> attributes, which specify the dimensions of the image in pixels:</p>

<pre><code>&lt;img src="photo.jpg" width="500" height="300" alt="Sunset photo"&gt;</code></pre>

<h3>Why Specify Dimensions?</h3>
<ul>
<li>Prevents layout shift while image loads</li>
<li>Improves page loading performance</li>
<li>Helps browsers allocate space correctly</li>
<li>Better user experience</li>
</ul>

<h3>The Critical alt Attribute</h3>
<p>The <code>alt</code> attribute provides alternative text for an image. This is <strong>required</strong> for accessibility:</p>

<pre><code>&lt;img src="puppy.jpg" alt="Golden retriever puppy playing in grass"&gt;</code></pre>

<h3>When alt Text is Used</h3>
<ul>
<li>Screen readers read it to visually impaired users</li>
<li>Displayed if image fails to load</li>
<li>Used by search engines to understand images</li>
<li>Shown when users disable images</li>
</ul>

<h3>Writing Good alt Text</h3>
<ul>
<li>Be descriptive but concise</li>
<li>Don\'t start with "image of" or "picture of"</li>
<li>Include important text in images</li>
<li>Use empty alt="" for decorative images</li>
</ul>

<pre><code>&lt;!-- Good examples --&gt;
&lt;img src="chart.png" alt="Sales increased 25% from 2022 to 2023"&gt;
&lt;img src="ceo.jpg" alt="Jane Smith, CEO of TechCorp"&gt;
&lt;img src="decoration.png" alt=""&gt; &lt;!-- Decorative image --&gt;

&lt;!-- Bad examples --&gt;
&lt;img src="chart.png" alt="Chart"&gt;
&lt;img src="ceo.jpg" alt="Image of a person"&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 4,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Style, Lang, and Title Attributes',
            'content' => '<h3>The style Attribute</h3>
<p>The <code>style</code> attribute is used to add inline CSS styles to an element:</p>

<pre><code>&lt;p style="color:red;"&gt;This is a red paragraph.&lt;/p&gt;
&lt;div style="background-color: yellow; padding: 10px;"&gt;
    Highlighted box
&lt;/div&gt;</code></pre>

<p><strong>Note:</strong> While convenient, inline styles should be used sparingly. External CSS files are preferred for maintainability.</p>

<h3>The lang Attribute</h3>
<p>You should always include the <code>lang</code> attribute inside the <code>&lt;html&gt;</code> tag to declare the language of the page:</p>

<pre><code>&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;body&gt;
    &lt;p&gt;This page is in English.&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;</code></pre>

<h3>Why lang is Important</h3>
<ul>
<li>Helps search engines return language-specific results</li>
<li>Assists screen readers with pronunciation</li>
<li>Helps browsers offer translation</li>
<li>Important for SEO</li>
</ul>

<h3>Language with Country Codes</h3>
<pre><code>&lt;html lang="en-US"&gt; &lt;!-- American English --&gt;
&lt;html lang="en-GB"&gt; &lt;!-- British English --&gt;
&lt;html lang="es-MX"&gt; &lt;!-- Mexican Spanish --&gt;
&lt;html lang="fr-CA"&gt; &lt;!-- Canadian French --&gt;</code></pre>

<h3>The title Attribute</h3>
<p>The <code>title</code> attribute provides extra information about an element. It\'s displayed as a tooltip on hover:</p>

<pre><code>&lt;p title="World Health Organization"&gt;WHO&lt;/p&gt;
&lt;abbr title="Hypertext Markup Language"&gt;HTML&lt;/abbr&gt;
&lt;a href="#" title="Click for more information"&gt;Learn more&lt;/a&gt;</code></pre>

<p><strong>Accessibility Note:</strong> Don\'t rely solely on title for important information, as it\'s not accessible on touch devices and may not be read by screen readers.</p>',
            'content_type' => 'text',
            'order_index' => 5,
        ]);

        Topic::create([
            'lesson_id' => $lesson->id,
            'title' => 'Best Practices for Attributes',
            'content' => '<h3>Always Use Lowercase Attributes</h3>
<p>HTML allows uppercase attribute names, but lowercase is strongly recommended:</p>

<pre><code>&lt;!-- Good - Recommended --&gt;
&lt;div class="container" id="main"&gt;Content&lt;/div&gt;

&lt;!-- Bad - Not recommended --&gt;
&lt;div CLASS="container" ID="main"&gt;Content&lt;/div&gt;</code></pre>

<h3>Always Quote Attribute Values</h3>
<p>HTML allows unquoted values in some cases, but always use quotes:</p>

<pre><code>&lt;!-- Good - Always use quotes --&gt;
&lt;a href="https://example.com" class="link"&gt;Link&lt;/a&gt;

&lt;!-- Bad - Works but not recommended --&gt;
&lt;a href=https://example.com class=link&gt;Link&lt;/a&gt;

&lt;!-- Broken - Spaces require quotes --&gt;
&lt;p title=About Us&gt;This will break!&lt;/p&gt;</code></pre>

<h3>Single or Double Quotes?</h3>
<p>Double quotes are most common, but single quotes are also valid:</p>

<pre><code>&lt;!-- Both are valid --&gt;
&lt;a href="page.html" title="Link to page"&gt;Double quotes&lt;/a&gt;
&lt;a href=\'page.html\' title=\'Link to page\'&gt;Single quotes&lt;/a&gt;

&lt;!-- Useful when quotes are in the value --&gt;
&lt;p title=\'John "Boss" Smith\'&gt;Single quotes outside&lt;/p&gt;
&lt;p title="John \'Boss\' Smith"&gt;Double quotes outside&lt;/p&gt;</code></pre>

<h3>Attribute Order</h3>
<p>While not required, a consistent attribute order improves readability:</p>
<ol>
<li>id</li>
<li>class</li>
<li>src/href</li>
<li>alt/title</li>
<li>width/height</li>
<li>style</li>
</ol>

<pre><code>&lt;!-- Consistent ordering --&gt;
&lt;img id="hero" class="responsive" src="hero.jpg" alt="Hero image" width="1200" height="600"&gt;
&lt;a id="cta" class="button primary" href="/signup" title="Sign up now"&gt;Get Started&lt;/a&gt;</code></pre>',
            'content_type' => 'text',
            'order_index' => 6,
        ]);

        // Add code example
        CodeExample::create([
            'lesson_id' => $lesson->id,
            'title' => 'Complete Attribute Example',
            'description' => 'Practice using various HTML attributes',
            'language' => 'html',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Attribute Practice</title>
</head>
<body>
    <!-- Practice adding attributes here -->
    <h1>My Portfolio</h1>
    
    <p>Welcome to my website!</p>
    
    <a>Visit my blog</a>
    
    <img>
    
    <div>
        <p>Contact me at: email@example.com</p>
    </div>
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attribute Practice - John\'s Portfolio</title>
</head>
<body>
    <h1 id="main-title" class="header" style="color: #333;">My Portfolio</h1>
    
    <p title="Introduction paragraph">Welcome to my website!</p>
    
    <a href="https://myblog.com" target="_blank" rel="noopener" title="Visit my tech blog">Visit my blog</a>
    
    <img src="profile.jpg" alt="John Smith, web developer" width="300" height="300" class="profile-image">
    
    <div id="contact" class="contact-section" style="background-color: #f0f0f0; padding: 20px;">
        <p>Contact me at: <a href="mailto:john@example.com" title="Send me an email">john@example.com</a></p>
        <p>Or call: <a href="tel:+1234567890" title="Call me">123-456-7890</a></p>
    </div>
</body>
</html>',
            'instructions' => 'Add appropriate attributes to make this page functional and accessible:
1. Add lang attribute to html element
2. Add id and class attributes to the h1
3. Add href, target, and rel attributes to the blog link
4. Add complete attributes to the img tag (src, alt, width, height)
5. Add mailto link for the email
6. Use title attributes for tooltips
7. Add some inline styles using the style attribute',
            'order_index' => 1,
        ]);

        // Add activity
        Activity::create([
            'lesson_id' => $lesson->id,
            'title' => 'Build an Accessible Photo Gallery',
            'description' => 'Create a photo gallery with proper attributes for accessibility and functionality',
            'activity_type' => 'coding',
            'instructions' => '<h3>Create an Accessible Photo Gallery</h3>
<p>Build a photo gallery that demonstrates proper use of HTML attributes for accessibility and user experience.</p>

<h3>Requirements</h3>
<ul>
<li>HTML document with proper lang attribute</li>
<li>At least 4 images with complete attributes</li>
<li>Navigation links with appropriate attributes</li>
<li>Proper use of id and class attributes</li>
<li>Tooltips using title attributes</li>
<li>Email and external links</li>
</ul>

<h3>Must Include</h3>
<ul>
<li>Gallery title with id attribute</li>
<li>Images with src, alt, width, and height</li>
<li>Links that open in new tabs (with security)</li>
<li>Contact section with mailto link</li>
<li>Download link for a resource</li>
<li>Inline styles on at least 2 elements</li>
</ul>',
            'initial_code' => '<!DOCTYPE html>
<html>
<head>
    <title>Photo Gallery</title>
</head>
<body>
    <!-- Build your accessible photo gallery here -->
    
</body>
</html>',
            'solution_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <title>Nature Photography Gallery</title>
</head>
<body>
    <h1 id="gallery-title" class="main-header" style="text-align: center; color: #2c5530;">Nature Photography Gallery</h1>
    
    <nav id="gallery-nav" class="navigation">
        <a href="#landscapes" title="View landscape photos">Landscapes</a> |
        <a href="#wildlife" title="View wildlife photos">Wildlife</a> |
        <a href="#macro" title="View macro photography">Macro</a> |
        <a href="https://naturephotoblog.com" target="_blank" rel="noopener" title="Visit my photography blog">My Blog</a>
    </nav>
    
    <div id="landscapes" class="gallery-section" style="margin: 20px 0;">
        <h2>Landscape Photography</h2>
        <img src="mountain-sunset.jpg" alt="Orange sunset behind snow-capped mountains" width="400" height="300" class="gallery-image">
        <img src="ocean-waves.jpg" alt="Turquoise waves crashing on sandy beach" width="400" height="300" class="gallery-image">
    </div>
    
    <div id="wildlife" class="gallery-section" style="margin: 20px 0;">
        <h2>Wildlife Photography</h2>
        <img src="eagle-flight.jpg" alt="Bald eagle soaring through blue sky" width="400" height="300" class="gallery-image" title="Captured in Alaska">
        <img src="deer-forest.jpg" alt="White-tailed deer standing in misty forest" width="400" height="300" class="gallery-image" title="Early morning shot">
    </div>
    
    <div id="macro" class="gallery-section" style="margin: 20px 0;">
        <h2>Macro Photography</h2>
        <img src="dewdrop-leaf.jpg" alt="Morning dewdrops on green leaf showing reflection" width="400" height="300" class="gallery-image">
        <img src="butterfly-flower.jpg" alt="Monarch butterfly on purple coneflower" width="400" height="300" class="gallery-image">
    </div>
    
    <footer id="contact-info" class="footer" style="background-color: #f5f5f5; padding: 15px; margin-top: 30px;">
        <h3>Contact & Resources</h3>
        <p>Email: <a href="mailto:photographer@nature.com" title="Send me an email">photographer@nature.com</a></p>
        <p>Phone: <a href="tel:+15551234567" title="Call for bookings">555-123-4567</a></p>
        <p><a href="photography-guide.pdf" download title="Download free photography guide">Download Photography Guide</a></p>
        <p>Follow on <a href="https://instagram.com/naturephotos" target="_blank" rel="noopener" title="See more photos on Instagram">Instagram</a></p>
    </footer>
</body>
</html>',
            'test_cases' => [
                [
                    'description' => 'HTML has lang attribute',
                    'test_type' => 'regex',
                    'expected' => '<html[^>]+lang=',
                    'points' => 10
                ],
                [
                    'description' => 'Contains at least 4 images with alt text',
                    'test_type' => 'count',
                    'expected' => '<img[^>]+alt=',
                    'min_count' => 4,
                    'points' => 20
                ],
                [
                    'description' => 'Images have width and height',
                    'test_type' => 'regex',
                    'expected' => '<img[^>]+width=[^>]+height=',
                    'points' => 15
                ],
                [
                    'description' => 'Contains mailto link',
                    'test_type' => 'regex',
                    'expected' => 'href="mailto:',
                    'points' => 10
                ],
                [
                    'description' => 'Has external links with target="_blank"',
                    'test_type' => 'regex',
                    'expected' => 'target="_blank"',
                    'points' => 10
                ],
                [
                    'description' => 'Uses rel="noopener" for security',
                    'test_type' => 'regex',
                    'expected' => 'rel="noopener"',
                    'points' => 10
                ],
                [
                    'description' => 'Contains download link',
                    'test_type' => 'regex',
                    'expected' => 'download',
                    'points' => 10
                ],
                [
                    'description' => 'Uses id attributes',
                    'test_type' => 'count',
                    'expected' => ' id="',
                    'min_count' => 3,
                    'points' => 15
                ]
            ],
            'hints' => [
                'Don\'t forget the lang attribute on the html element',
                'Every image needs an alt attribute for accessibility',
                'Use target="_blank" with rel="noopener" for external links',
                'The download attribute forces file download',
                'Use descriptive alt text for images'
            ],
            'difficulty' => 'intermediate',
            'points' => 100,
            'time_limit' => 3000,
            'order_index' => 1,
        ]);

        echo "HTML Attributes lesson created successfully!\n";
    }
}

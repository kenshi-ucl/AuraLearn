<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Activity;

class Html5ActivitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only coding activities
        $activities = [
            // Chapter 2 Coding Activities
            [
                'lesson_title' => '2.6 Your First Web Page',
                'title' => 'Create Your First Web Page',
                'type' => 'Coding',
                'content' => 'Create your first complete HTML5 web page from scratch. Your page should include all the required elements of a valid HTML5 document.',
                'instructions' => json_encode([
                    'Start with the HTML5 DOCTYPE declaration',
                    'Add the html element with lang attribute',
                    'Include a complete head section with charset and title',
                    'Add meaningful content in the body',
                    'Validate your HTML code'
                ]),
                'initial_code' => '<!-- Start your HTML5 document here -->',
                'expected_output' => 'A valid HTML5 document with proper structure',
                'hints' => json_encode([
                    'Remember to include <!DOCTYPE html>',
                    'Set lang="en" on the html element',
                    'Use UTF-8 charset in the meta tag',
                    'Give your page a descriptive title'
                ]),
                'difficulty' => 'beginner',
                'points' => 15,
                'time_limit' => 30,
                'max_attempts' => 5,
                'passing_score' => 100
            ],
            [
                'lesson_title' => '2.16 Structural Elements',
                'title' => 'Build a Semantic HTML5 Page',
                'type' => 'Coding',
                'content' => 'Create a complete HTML5 page using semantic structural elements. Your page should represent a simple blog or article page with proper semantic structure.',
                'instructions' => json_encode([
                    'Use header element with site title and navigation',
                    'Create a nav element with at least 3 links',
                    'Use main element for primary content',
                    'Include at least one article element',
                    'Add an aside element with related information',
                    'Include a footer with copyright information'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>My Semantic HTML5 Page</title>
</head>
<body>
    <!-- Build your semantic structure here -->
</body>
</html>',
                'expected_output' => 'A well-structured HTML5 page using semantic elements',
                'hints' => json_encode([
                    'header typically contains site branding and main navigation',
                    'nav should contain a list of navigation links',
                    'main wraps the primary content of the page',
                    'article represents self-contained content',
                    'aside is for tangentially related content',
                    'footer typically contains copyright and contact info'
                ]),
                'difficulty' => 'intermediate',
                'points' => 25,
                'time_limit' => 45,
                'max_attempts' => 3,
                'passing_score' => 85
            ],
            [
                'lesson_title' => '2.17 Hyperlinks',
                'title' => 'Create a Navigation System',
                'type' => 'Coding',
                'content' => 'Build a multi-page navigation system using various types of hyperlinks. Create at least 3 interconnected HTML pages with proper navigation.',
                'instructions' => json_encode([
                    'Create 3 HTML pages: index.html, about.html, contact.html',
                    'Add navigation links between all pages',
                    'Include at least one external link',
                    'Add an email link in the contact page',
                    'Create internal page navigation using anchor links',
                    'Include at least one link that opens in a new tab'
                ]),
                'initial_code' => '<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Home - Navigation Exercise</title>
</head>
<body>
    <nav>
        <!-- Add your navigation here -->
    </nav>
    <h1>Home Page</h1>
    <!-- Add content and links -->
</body>
</html>',
                'expected_output' => 'Three interconnected HTML pages with complete navigation',
                'hints' => json_encode([
                    'Use relative paths for internal page links',
                    'Use href="mailto:email@example.com" for email links',
                    'Use target="_blank" to open in new tab',
                    'Use #id for internal page anchors',
                    'Always provide meaningful link text'
                ]),
                'difficulty' => 'intermediate',
                'points' => 30,
                'time_limit' => 60,
                'max_attempts' => 3,
                'passing_score' => 80
            ],
            [
                'lesson_title' => 'Chapter 2 Summary & Key Terms',
                'title' => 'Chapter 2 Website Case Study',
                'type' => 'Project',
                'content' => 'JavaJam Coffee Bar Case Study

Create a complete website for JavaJam Coffee Bar following these specifications:

JavaJam Coffee Bar is a gourmet coffee shop that serves snacks, coffee, tea, and soft drinks. Visit JavaJam to experience the rich aroma and taste that only fresh-roasted coffee can provide.

The website should include:
1. Home page (index.html) - Welcome message and overview
2. Menu page (menu.html) - List of beverages and prices
3. Music page (music.html) - Information about live music events
4. Jobs page (jobs.html) - Employment opportunities

Each page should include consistent navigation and footer information.',
                'instructions' => json_encode([
                    'Create 4 interconnected HTML pages',
                    'Use semantic HTML5 elements throughout',
                    'Include consistent navigation on all pages',
                    'Add appropriate headings and content structure',
                    'Use lists for menu items and schedules',
                    'Include contact information in the footer',
                    'Validate all HTML pages'
                ]),
                'initial_code' => '',
                'expected_output' => 'Complete 4-page website for JavaJam Coffee Bar',
                'hints' => json_encode([
                    'Start with a template and reuse it for consistency',
                    'Use unordered lists for navigation',
                    'Use description lists for menu items with prices',
                    'Consider using tables for music schedules',
                    'Keep the design simple and focus on structure'
                ]),
                'difficulty' => 'advanced',
                'points' => 50,
                'time_limit' => 120,
                'max_attempts' => 2,
                'passing_score' => 85
            ],
            // Chapter 3 CSS Activities
            [
                'lesson_title' => '3.1 Inline CSS',
                'title' => 'Style Text with Inline CSS',
                'type' => 'Coding',
                'content' => 'Practice using inline CSS to style HTML elements. Apply colors, font sizes, and other basic styles directly to HTML elements.',
                'instructions' => json_encode([
                    'Create an HTML page with at least 5 different elements',
                    'Apply inline CSS to change text color on headings',
                    'Use inline CSS to change font size on paragraphs',
                    'Apply background colors to div elements',
                    'Style links with different colors for hover states'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Inline CSS Practice</title>
</head>
<body>
    <h1>Add inline styles to this heading</h1>
    <p>Style this paragraph with inline CSS</p>
    <div>Give this div a background color</div>
    <a href="#">Style this link</a>
</body>
</html>',
                'expected_output' => 'HTML page with inline CSS applied to multiple elements',
                'hints' => json_encode([
                    'Use style="" attribute on elements',
                    'Example: style="color: blue; font-size: 20px;"',
                    'Remember semicolons between CSS properties',
                    'Inline CSS has highest specificity'
                ]),
                'difficulty' => 'beginner',
                'points' => 20,
                'time_limit' => 30,
                'max_attempts' => 5,
                'passing_score' => 100
            ],
            [
                'lesson_title' => '3.2 Embedded CSS',
                'title' => 'Create Embedded Stylesheet',
                'type' => 'Coding',
                'content' => 'Create a complete webpage using embedded CSS in the head section. Style multiple elements using CSS selectors.',
                'instructions' => json_encode([
                    'Create a style element in the head section',
                    'Define styles for body, h1, h2, p, and div elements',
                    'Use class selectors to create reusable styles',
                    'Use ID selectors for unique elements',
                    'Apply CSS box model properties (margin, padding, border)'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Embedded CSS Practice</title>
    <style>
        /* Add your CSS rules here */
    </style>
</head>
<body>
    <h1>Main Title</h1>
    <div class="container">
        <h2>Section Title</h2>
        <p class="intro">Introduction paragraph</p>
        <p>Regular paragraph</p>
    </div>
    <div id="footer">Footer content</div>
</body>
</html>',
                'expected_output' => 'Styled webpage using embedded CSS with various selectors',
                'hints' => json_encode([
                    'Element selectors: h1 { color: blue; }',
                    'Class selectors: .intro { font-weight: bold; }',
                    'ID selectors: #footer { background-color: gray; }',
                    'Group selectors: h1, h2 { font-family: Arial; }'
                ]),
                'difficulty' => 'intermediate',
                'points' => 25,
                'time_limit' => 45,
                'max_attempts' => 3,
                'passing_score' => 85
            ],
            // Chapter 4 Graphics Activities
            [
                'lesson_title' => '4.1 Images on the Web',
                'title' => 'Create Image Gallery',
                'type' => 'Coding',
                'content' => 'Build an image gallery page with proper HTML5 image elements and accessibility features.',
                'instructions' => json_encode([
                    'Create an HTML page with at least 6 images',
                    'Use appropriate alt text for each image',
                    'Implement figure and figcaption elements',
                    'Apply CSS to create a grid layout for images',
                    'Add hover effects to images',
                    'Ensure images are responsive'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Image Gallery</title>
    <style>
        /* Add your gallery styles here */
    </style>
</head>
<body>
    <h1>My Image Gallery</h1>
    <!-- Build your gallery here -->
</body>
</html>',
                'expected_output' => 'Responsive image gallery with proper accessibility',
                'hints' => json_encode([
                    'Use <figure> and <figcaption> for semantic markup',
                    'Set max-width: 100% for responsive images',
                    'Use CSS Grid or Flexbox for layout',
                    'Add transition for smooth hover effects',
                    'Always include meaningful alt text'
                ]),
                'difficulty' => 'intermediate',
                'points' => 30,
                'time_limit' => 60,
                'max_attempts' => 3,
                'passing_score' => 80
            ],
            // Chapter 6 Layout Activities
            [
                'lesson_title' => '6.1 CSS Positioning',
                'title' => 'Master CSS Positioning',
                'type' => 'Coding',
                'content' => 'Create a webpage demonstrating all CSS positioning types: static, relative, absolute, fixed, and sticky.',
                'instructions' => json_encode([
                    'Create a header with fixed positioning',
                    'Add a navigation bar with sticky positioning',
                    'Create overlapping elements using absolute positioning',
                    'Use relative positioning for fine adjustments',
                    'Build a two-column layout with floats',
                    'Add a back-to-top button with fixed positioning'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CSS Positioning</title>
    <style>
        body { margin: 0; padding: 0; }
        /* Add positioning styles here */
    </style>
</head>
<body>
    <header>Fixed Header</header>
    <nav>Sticky Navigation</nav>
    <main>
        <div class="container">
            <!-- Content here -->
        </div>
    </main>
    <button class="back-to-top">↑</button>
</body>
</html>',
                'expected_output' => 'Page demonstrating all CSS positioning techniques',
                'hints' => json_encode([
                    'Fixed: position: fixed; top: 0; left: 0; right: 0;',
                    'Sticky: position: sticky; top: 0;',
                    'Absolute needs positioned parent (relative)',
                    'Z-index controls stacking order',
                    'Clear floats with clearfix'
                ]),
                'difficulty' => 'intermediate',
                'points' => 35,
                'time_limit' => 60,
                'max_attempts' => 3,
                'passing_score' => 80
            ],
            // Chapter 7 Responsive Design Activities
            [
                'lesson_title' => '7.1 Responsive Design with Flexbox',
                'title' => 'Build Responsive Flexbox Layout',
                'type' => 'Coding',
                'content' => 'Create a fully responsive webpage using CSS Flexbox that adapts to different screen sizes.',
                'instructions' => json_encode([
                    'Create a flex container with navigation items',
                    'Build a card layout using flexbox',
                    'Implement responsive behavior with flex-wrap',
                    'Use flex-grow, flex-shrink, and flex-basis',
                    'Add media queries for mobile, tablet, and desktop',
                    'Create a footer with flexbox alignment'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flexbox Layout</title>
    <style>
        * { box-sizing: border-box; }
        /* Add flexbox styles here */
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="nav-item">Home</a>
        <a href="#" class="nav-item">About</a>
        <a href="#" class="nav-item">Services</a>
        <a href="#" class="nav-item">Contact</a>
    </nav>
    <div class="card-container">
        <!-- Add cards here -->
    </div>
</body>
</html>',
                'expected_output' => 'Responsive flexbox layout that works on all devices',
                'hints' => json_encode([
                    'display: flex; enables flexbox',
                    'flex-direction: row | column',
                    'justify-content for main axis alignment',
                    'align-items for cross axis alignment',
                    'flex: 1 for equal width items'
                ]),
                'difficulty' => 'intermediate',
                'points' => 40,
                'time_limit' => 75,
                'max_attempts' => 3,
                'passing_score' => 85
            ],
            [
                'lesson_title' => '7.2 CSS Grid Layout',
                'title' => 'Create Complex Grid Layout',
                'type' => 'Coding',
                'content' => 'Build a magazine-style layout using CSS Grid with various grid areas and responsive behavior.',
                'instructions' => json_encode([
                    'Create a grid container with defined columns and rows',
                    'Use grid-template-areas for layout',
                    'Implement a header spanning full width',
                    'Create a sidebar and main content area',
                    'Add a feature article spanning multiple columns',
                    'Make the grid responsive with media queries'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSS Grid Layout</title>
    <style>
        * { box-sizing: border-box; }
        /* Add grid styles here */
    </style>
</head>
<body>
    <div class="grid-container">
        <header>Header</header>
        <nav>Navigation</nav>
        <aside>Sidebar</aside>
        <main>Main Content</main>
        <section class="feature">Feature Article</section>
        <footer>Footer</footer>
    </div>
</body>
</html>',
                'expected_output' => 'Magazine-style CSS Grid layout with responsive design',
                'hints' => json_encode([
                    'display: grid; enables CSS Grid',
                    'grid-template-columns: repeat(auto-fit, minmax(250px, 1fr))',
                    'grid-template-areas for named layout regions',
                    'grid-gap for spacing between items',
                    'Use fr units for flexible sizing'
                ]),
                'difficulty' => 'advanced',
                'points' => 45,
                'time_limit' => 90,
                'max_attempts' => 3,
                'passing_score' => 85
            ],
            // Chapter 8 Tables Activities
            [
                'lesson_title' => '8.1 HTML Tables',
                'title' => 'Build Data Table with Styling',
                'type' => 'Coding',
                'content' => 'Create a well-structured HTML table with proper semantic markup and attractive CSS styling.',
                'instructions' => json_encode([
                    'Create a table with header, body, and footer sections',
                    'Use th elements with scope attributes',
                    'Add caption for table description',
                    'Style alternating row colors',
                    'Add hover effects on rows',
                    'Make the table responsive with horizontal scroll'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HTML Table</title>
    <style>
        /* Add table styles here */
    </style>
</head>
<body>
    <h1>Product Inventory</h1>
    <!-- Create your table here -->
</body>
</html>',
                'expected_output' => 'Styled data table with semantic HTML and responsive behavior',
                'hints' => json_encode([
                    'Use <thead>, <tbody>, <tfoot> for structure',
                    'scope="col" or scope="row" on th elements',
                    ':nth-child(even) for alternating rows',
                    'border-collapse: collapse; for clean borders',
                    'overflow-x: auto; for responsive scroll'
                ]),
                'difficulty' => 'intermediate',
                'points' => 30,
                'time_limit' => 45,
                'max_attempts' => 3,
                'passing_score' => 80
            ],
            // Chapter 9 Forms Activities
            [
                'lesson_title' => '9.1 HTML Forms',
                'title' => 'Create Contact Form',
                'type' => 'Coding',
                'content' => 'Build a professional contact form with various HTML5 input types and proper validation.',
                'instructions' => json_encode([
                    'Create form with text, email, and tel inputs',
                    'Add textarea for message',
                    'Include select dropdown and radio buttons',
                    'Use HTML5 validation attributes',
                    'Style the form with CSS',
                    'Add focus and error states'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Contact Form</title>
    <style>
        /* Add form styles here */
    </style>
</head>
<body>
    <h1>Contact Us</h1>
    <form>
        <!-- Build your form here -->
    </form>
</body>
</html>',
                'expected_output' => 'Professional contact form with validation and styling',
                'hints' => json_encode([
                    'Use required attribute for mandatory fields',
                    'type="email" for email validation',
                    'pattern attribute for custom validation',
                    'Label elements for accessibility',
                    ':invalid and :valid pseudo-classes for styling'
                ]),
                'difficulty' => 'intermediate',
                'points' => 35,
                'time_limit' => 60,
                'max_attempts' => 3,
                'passing_score' => 85
            ],
            [
                'lesson_title' => '9.2 Advanced Forms',
                'title' => 'Build Registration Form with CSS Grid',
                'type' => 'Coding',
                'content' => 'Create a multi-step registration form using CSS Grid for layout and advanced HTML5 form features.',
                'instructions' => json_encode([
                    'Design a two-column form layout with CSS Grid',
                    'Use fieldsets to group related inputs',
                    'Implement date, time, and color inputs',
                    'Add file upload with accept attribute',
                    'Create custom styled checkboxes and radio buttons',
                    'Use datalist for autocomplete suggestions'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Registration Form</title>
    <style>
        * { box-sizing: border-box; }
        /* Add grid and form styles here */
    </style>
</head>
<body>
    <h1>User Registration</h1>
    <form class="registration-form">
        <!-- Build your advanced form here -->
    </form>
</body>
</html>',
                'expected_output' => 'Advanced registration form with grid layout and HTML5 features',
                'hints' => json_encode([
                    'Use CSS Grid for form layout',
                    'fieldset and legend for grouping',
                    'input type="date" for date picker',
                    'Custom checkbox: input + label styling',
                    '<datalist> with <option> elements for suggestions'
                ]),
                'difficulty' => 'advanced',
                'points' => 45,
                'time_limit' => 90,
                'max_attempts' => 3,
                'passing_score' => 85
            ],
            // Chapter 11 Multimedia Activities
            [
                'lesson_title' => '11.1 HTML5 Video and Audio',
                'title' => 'Create Media Player Page',
                'type' => 'Coding',
                'content' => 'Build a multimedia page with HTML5 video and audio elements, including custom controls and styling.',
                'instructions' => json_encode([
                    'Add HTML5 video element with controls',
                    'Include multiple source formats',
                    'Add poster image for video',
                    'Create audio player with playlist',
                    'Style media elements with CSS',
                    'Add captions/subtitles track'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Media Player</title>
    <style>
        /* Add media styles here */
    </style>
</head>
<body>
    <h1>HTML5 Media Showcase</h1>
    <!-- Add video player here -->
    <!-- Add audio player here -->
</body>
</html>',
                'expected_output' => 'Multimedia page with styled video and audio players',
                'hints' => json_encode([
                    '<video controls width="640" height="360">',
                    'Multiple <source> for format compatibility',
                    'poster attribute for preview image',
                    '<track kind="captions"> for accessibility',
                    'Use CSS to style controls container'
                ]),
                'difficulty' => 'intermediate',
                'points' => 35,
                'time_limit' => 60,
                'max_attempts' => 3,
                'passing_score' => 80
            ],
            [
                'lesson_title' => '11.2 CSS Animations',
                'title' => 'Create Animated Landing Page',
                'type' => 'Coding',
                'content' => 'Build an engaging landing page with CSS animations, transitions, and transforms.',
                'instructions' => json_encode([
                    'Create entrance animations for hero text',
                    'Add hover transitions on buttons',
                    'Implement a loading spinner animation',
                    'Create parallax scrolling effect',
                    'Add keyframe animations for elements',
                    'Use transform for 3D card flip effect'
                ]),
                'initial_code' => '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Animated Landing Page</title>
    <style>
        * { box-sizing: border-box; }
        /* Add animation styles here */
    </style>
</head>
<body>
    <section class="hero">
        <h1 class="hero-title">Welcome</h1>
        <p class="hero-subtitle">Discover Amazing Animations</p>
        <button class="cta-button">Get Started</button>
    </section>
    <div class="spinner"></div>
    <div class="card-flip">
        <div class="card-front">Front</div>
        <div class="card-back">Back</div>
    </div>
</body>
</html>',
                'expected_output' => 'Landing page with smooth animations and transitions',
                'hints' => json_encode([
                    '@keyframes for custom animations',
                    'animation: name duration timing-function',
                    'transition: property duration easing',
                    'transform: rotate() scale() translate()',
                    'animation-fill-mode: forwards to keep final state'
                ]),
                'difficulty' => 'advanced',
                'points' => 50,
                'time_limit' => 90,
                'max_attempts' => 3,
                'passing_score' => 85
            ]
        ];

        foreach ($activities as $activityData) {
            // Find the lesson
            $lesson = Lesson::where('title', $activityData['lesson_title'])->first();
            
            if (!$lesson) {
                $this->command->warn("Lesson not found for activity: {$activityData['lesson_title']}");
                continue;
            }

            // Map activity types to the coding activity format
            $activityType = 'coding'; // All activities will be coding type as per schema comment
            
            // Store coding-related data in questions JSON field
            $questions = [
                'content' => $activityData['content'],
                'initial_code' => $activityData['initial_code'],
                'expected_output' => $activityData['expected_output'],
                'hints' => json_decode($activityData['hints']),
                'difficulty' => $activityData['difficulty']
            ];
            
            // Create the activity
            $activity = Activity::firstOrCreate(
                [
                    'lesson_id' => $lesson->id,
                    'title' => $activityData['title']
                ],
                [
                    'lesson_id' => $lesson->id,
                    'title' => $activityData['title'],
                    'description' => substr($activityData['content'], 0, 200) . '...', // Brief description
                    'activity_type' => $activityType,
                    'instructions' => $activityData['instructions'],
                    'questions' => json_encode($questions),
                    'points' => $activityData['points'],
                    'time_limit' => $activityData['time_limit'],
                    'max_attempts' => $activityData['max_attempts'],
                    'passing_score' => $activityData['passing_score'],
                    'is_published' => 1,
                    'order_index' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            if ($activity->wasRecentlyCreated) {
                $this->command->info("Created activity: {$activityData['title']}");
            } else {
                $this->command->info("Activity already exists: {$activityData['title']}");
            }
        }

        $this->command->info('All activities created successfully.');
    }
}

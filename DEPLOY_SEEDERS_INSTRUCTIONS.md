# Deploying HTML Course Content to Heroku

## Files Created
- `database/seeders/HTMLCourseExpansionSeeder.php` - Updates HTML Editors & Basic lessons, adds Elements & Attributes lessons
- `database/seeders/HTMLCourseExpansionSeeder_Part2.php` - Adds Headings, Paragraphs, Styles & Formatting lessons

## Running Seeders on Heroku

### Option 1: Via Heroku CLI (Recommended)

1. First, ensure your Heroku app is deployed with the latest code:
```bash
git push heroku main
```

2. Run the seeders on Heroku:
```bash
# First ensure the base course exists
heroku run php artisan db:seed --class=CourseSeeder --force --app=your-app-name

# Then run the expansion seeders
heroku run php artisan db:seed --class=HTMLCourseExpansionSeeder --force --app=your-app-name
heroku run php artisan db:seed --class=HTMLCourseExpansionSeeder_Part2 --force --app=your-app-name
```

### Option 2: Via Heroku Dashboard

1. Go to your Heroku app dashboard
2. Click on "More" → "Run console"
3. Run each command:
   - `php artisan db:seed --class=CourseSeeder --force`
   - `php artisan db:seed --class=HTMLCourseExpansionSeeder --force`
   - `php artisan db:seed --class=HTMLCourseExpansionSeeder_Part2 --force`

## What These Seeders Add

### HTMLCourseExpansionSeeder
1. **HTML Editors Lesson** - Complete update with:
   - Getting Started with Text Editors
   - Writing Your First HTML
   - Saving and Viewing HTML Files
   - Online HTML Editors
   - Activity: Create Your Personal Web Page

2. **HTML Basic Lesson** - Complete update with:
   - HTML Documents structure
   - HTML Headings basics
   - HTML Paragraphs
   - HTML Links
   - HTML Images
   - Viewing HTML Source Code
   - Activity: Build a Recipe Page

3. **HTML Elements Lesson** - New lesson with:
   - What are HTML Elements?
   - Nested HTML Elements
   - Never Skip the End Tag
   - Empty HTML Elements
   - HTML is Not Case Sensitive
   - Activity: Build a Nested Navigation Menu

4. **HTML Attributes Lesson** - New lesson with:
   - Understanding HTML Attributes
   - The href Attribute
   - The src Attribute
   - Width, Height, and Alt Attributes
   - Style, Lang, and Title Attributes
   - Best Practices for Attributes
   - Activity: Build an Accessible Photo Gallery

### HTMLCourseExpansionSeeder_Part2
1. **HTML Headings Lesson** - New lesson with:
   - Introduction to HTML Headings
   - Headings Are Important
   - Proper Heading Hierarchy
   - Styling Headings
   - Activity: Create a Technical Documentation Page

2. **HTML Paragraphs Lesson** - New lesson with:
   - Creating Paragraphs
   - HTML Display Behavior
   - Horizontal Rules and Line Breaks
   - The Pre Element
   - Activity: Create a Blog Post Layout

3. **HTML Styles Lesson** - New lesson with:
   - The HTML Style Attribute
   - Background Color
   - Text Color and Font Styles
   - Text Size
   - Text Alignment
   - Activity: Create a Styled Business Card

4. **HTML Text Formatting Lesson** - New lesson with:
   - HTML Formatting Elements
   - Bold and Strong Elements
   - Italic and Emphasized Elements
   - Small, Mark, Del, and Ins Elements
   - Subscript and Superscript
   - Activity: Create a Scientific Article

## Verifying the Deployment

After running the seeders, you can verify by:
1. Checking your frontend to see if all lessons appear
2. Running `heroku run php artisan tinker` and checking:
   ```php
   \App\Models\Lesson::where('course_id', 1)->count(); // Should show all lessons
   \App\Models\Topic::count(); // Should show all topics
   \App\Models\Activity::count(); // Should show all activities
   ```

## Troubleshooting

If you get errors:
1. Make sure the HTML5 course exists first (run CourseSeeder)
2. Check Heroku logs: `heroku logs --tail`
3. Ensure database migrations are up to date: `heroku run php artisan migrate`

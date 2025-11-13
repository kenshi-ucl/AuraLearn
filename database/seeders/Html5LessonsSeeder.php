<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;

class Html5LessonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find the HTML5 course
        $course = Course::where('slug', 'html5-tutorial')->first();
        
        if (!$course) {
            $this->command->error('HTML5 Tutorial course not found. Please run Html5CourseSeeder first.');
            return;
        }

        // Define all lessons - parsed from the JSON and CSV data
        $lessons = [
            // Chapter 1 lessons
            [
                'course_id' => $course->id,
                'title' => '1.1 The Internet and the Web',
                'description' => 'Understanding the Internet as a global network and the World Wide Web',
                'content' => 'The Internet is an interconnected network of computer networks that spans the globe and has become part of everyday life. It began as a small network (ARPAnet) connecting research computers, designed to reroute data if parts were damaged. Over time, other networks joined, and by 1991 the Internet opened to commercial use. The World Wide Web was invented by Tim Berners-Lee in 1991 as a way for researchers to hyperlink documents. Early web pages were text-based and used HTML for formatting and HTTP for communication. In 1993, Mosaic became the first graphical web browser, paving the way for the Web\'s rapid growth. By the early 1990s, user-friendly operating systems, affordable Internet connections (through services like AOL and CompuServe), and the introduction of HTML, HTTP, and graphical browsers converged to make the Web accessible to the public. As usage grew, no single entity was in charge of the Internet; instead, groups like the Internet Engineering Task Force (IETF) and Internet Architecture Board (IAB) oversee technical standards. The Internet Corporation for Assigned Names and Numbers (ICANN) coordinates domain names and IP addresses, with help from the Internet Assigned Numbers Authority (IANA). Organizations can use private networks: an intranet (for internal use) or an extranet (to share information with partners securely).',
                'order_index' => 1,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.2 Web Standards and Accessibility',
                'description' => 'W3C standards and web accessibility guidelines',
                'content' => 'No single person or group governs the World Wide Web, but the World Wide Web Consortium (W3C) plays a key role by developing recommendations for web standards, including web architecture, design standards, and accessibility. W3C Recommendations are guidelines (not rules) created with industry input, and while browsers sometimes diverge, there is a trend toward compliance. Following W3C standards helps ensure websites are accessible. The W3C\'s Web Accessibility Initiative (WAI) develops guidelines to help those with disabilities access the Web (see the Web Content Accessibility Guidelines, WCAG). For example, WCAG 2.1 extends earlier guidelines to better support mobile and low-vision accessibility. In the United States, laws like the Americans with Disabilities Act (ADA) prohibit disability-based web access discrimination, and Section 508 requires federal websites to be accessible (recently updated to align with WCAG 2.0). Universal design is the practice of making products and environments usable by as many people as possible. For web developers, designing with universal design principles and accessibility in mind not only helps users with visual, auditory, physical, or neurological challenges, but often improves the user experience for all users (for example, providing text alternatives for images not only aids screen readers but also helps mobile users or search engines).',
                'order_index' => 2,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.3 Information on the Web',
                'description' => 'Evaluating web content and ethical use of information',
                'content' => 'With anyone able to publish on the Web, it\'s critical to evaluate the reliability of online information. When researching online, ask: <strong>Is the organization credible?</strong> (Check if a site has its own domain name and consider the type of domain; .edu or .gov sites can be more objective than .com businesses or random free-hosted sites.) <strong>How recent is the information?</strong> (Check for last updated dates; outdated pages may not be reliable.) <strong>Are there links to additional resources?</strong> (Good information is often supported by references and external links.) <strong>Is it Wikipedia?</strong> (Wikipedia is a useful starting point, but since anyone can edit it, you should verify facts through the references listed and other sources.)<br><br><strong>Ethical Use of Information:</strong> Consider the ethics of using material from the Web. Is it okay to use someone else\'s graphic or website design on your own site? Copy someone\'s writing or insult someone online? The answer is <strong>no</strong> to all. Using someone\'s content without permission is stealing (and possibly consuming their bandwidth if hot-linked). Always ask permission, give credit, or use resources licensed for sharing (such as those under Creative Commons). Content on websites is automatically copyrighted, even if not explicitly labeled. Defaming someone online can have legal consequences. Good web practice involves requesting permission for others\' work, citing sources, and exercising free speech responsibly. Creative Commons licenses allow creators to permit certain uses of their work under specified conditions. These licenses help others know how they can use or adapt content you created.<br><br><em>Checkpoint 1.1:</em><br>1. Describe the difference between the Internet and the Web.<br>2. Explain three events that contributed to the commercialization and growth of the Internet.<br>3. Is the concept of universal design important to web developers? Explain.',
                'order_index' => 3,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.4 Network Overview',
                'description' => 'Understanding computer networks, LANs, and WANs',
                'content' => 'A network consists of two or more computers connected for the purpose of communicating and sharing resources. Common components of a network include servers (computer(s) that provide resources), client workstation computers, shared devices such as printers, and networking devices (routers, hubs, switches) and the media that connect them. A <strong>local area network (LAN)</strong> is usually confined to a single building or group of connected buildings. (Your school\'s computer lab is likely a LAN.) A <strong>wide area network (WAN)</strong> is geographically dispersed and usually uses some form of public or commercial communications network. For example, an organization with offices on both the East and West coasts of the United States probably uses a WAN to provide a link between the LANs at each of the offices.',
                'order_index' => 4,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.5 The Client/Server Model',
                'description' => 'Understanding how web clients and servers communicate',
                'content' => 'The term <strong>client/server</strong> dates from the 1980s and refers to personal computers joined by a network. "Client/server" can also describe a relationship between two computer programs – the client and the server. The client requests some type of service (such as a file or database access) from the server. The server fulfills the request and transmits the results to the client over a network. While both the client and the server programs can reside on the same computer, typically they run on different computers (Figure 1.5). It is common for a server to handle requests from multiple clients.<br><br><strong>Web Client</strong> – Connected to the Internet when needed; usually runs web browser software (e.g., Chrome or Edge); uses HTTP or HTTPS; requests web pages from a server; receives web pages and files from a server.<br><strong>Web Server</strong> – Continually connected to the Internet; runs web server software (e.g., Apache or IIS); uses HTTP or HTTPS; receives requests for web pages; responds to requests and transmits the status code, web page, and associated files.<br><br>When clients and servers exchange files, they often need to indicate the type of file being transferred; this is done using <strong>MIME types</strong> (Multipurpose Internet Mail Extensions). MIME allows multimedia documents to be exchanged among different systems. It defines types for files like audio, video, image, application, etc., and also subtypes for more detail. For example, a web page has MIME type text/html, a GIF image is image/gif, JPEG is image/jpeg. When a web server sends a file, it includes the MIME type so the browser knows how to handle the file.',
                'order_index' => 5,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.6 Internet Protocols',
                'description' => 'FTP, Email protocols, HTTP/HTTPS, TCP/IP, and DNS',
                'content' => $this->convertToHtml('Protocols are rules that describe how clients and servers communicate over a network. There is no single protocol that makes the Internet and Web work; many protocols with specific functions are needed in combination.

**File Transfer Protocol (FTP)** – A set of rules allowing files to be exchanged between computers on the Internet. Unlike HTTP (which is used for web page requests), FTP is used simply to move files from one computer to another. Web developers use FTP to transfer web files from their computers to web servers, and it\'s also used for downloading files from servers to individual computers.
**E-mail Protocols** – Sending and receiving email uses separate protocols. **Simple Mail Transfer Protocol (SMTP)** is used to send email. When receiving email, **Post Office Protocol (POP3)** or **Internet Message Access Protocol (IMAP)** can be used.
**Hypertext Transfer Protocol (HTTP)** – A set of rules for exchanging files (text, images, multimedia, etc.) on the Web. Browsers and web servers use HTTP. When a user enters a URL or clicks a link, the browser sends an HTTP request to the server. The web server receives the request, processes it, and responds with the requested file(s).
**Hypertext Transfer Protocol Secure (HTTPS)** – HTTPS combines HTTP with a security protocol (such as SSL/TLS) to encrypt data between the browser and the web server. (See Chapter 12 for more about HTTPS.)
**Transmission Control Protocol/Internet Protocol (TCP/IP)** – The official communication protocol of the Internet. **TCP** ensures the integrity of communication. It breaks files/messages into packets (see Figure 1.6) containing destination, source, sequence, and checksum info. TCP verifies that packets arrive intact (using the checksum), requests resend of any damaged packets, and reassembles the message from packets. **IP** works with TCP to route each packet to the correct destination address. Each Internet-connected device has a unique numeric **IP address**. The original IP version (IPv4) uses 32-bit addresses (e.g., 216.58.194.46), allowing about 4 billion addresses (though many are reserved or unusable). With the explosion of devices, **IPv6** was introduced, using 128-bit addresses (providing 2^128 possible addresses – enough for virtually all devices we can imagine). IPv6 is backward-compatible and being gradually adopted.
**Domain Name System (DNS)** – DNS associates domain names with IP addresses. When you type a URL (like example.com), DNS servers translate the domain name to the corresponding IP address. For instance, at the time of writing, Google\'s domain (google.com) corresponded to an IP like 216.58.194.46. You could enter that IP directly to reach Google, but domain names are easier to remember. The DNS ensures that behind the scenes, the text-based name you enter is converted to the numeric IP so the network can route your request to the right server.

*FAQ – What is HTTP/2?* HTTP/2 is the first major update to HTTP (introduced in 1999). As websites include more images and media, the number of requests to load a page has increased. HTTP/2\'s major benefit is faster page loads by allowing multiple concurrent requests over a single connection (multiplexing). It also compresses headers and can prioritize requests. (See the HTTP/2 documentation for more details.)'),
                'order_index' => 6,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.7 Uniform Resource Identifiers and Domain Names',
                'description' => 'Understanding URIs, URLs, and the domain name system',
                'content' => $this->convertToHtml('A **Uniform Resource Identifier (URI)** identifies a resource on the Internet. A **Uniform Resource Locator (URL)** is a common type of URI that gives the address of a resource (like a page, image, or file) and how to retrieve it (the protocol). For example, in the URL `http://www.webdevfoundations.net/chapter1/index.html`, *http* is the protocol, *www.webdevfoundations.net* is the domain name (and server), and *chapter1/index.html* is the path to a specific file on that server.
**Domain Names** – A domain name locates an organization or entity on the Internet. It associates with an IP address behind the scenes. For instance, *google.com* is the domain name for Google. In a URL like **http://maps.google.com**, "maps" is a subdomain (pointing to the Google Maps service), "google" is the second-level domain, and ".com" is the top-level domain (TLD). Together, maps.google.com is a fully qualified domain name (FQDN).
**Top-Level Domains (TLDs)** – The rightmost part of a domain name (after the final dot) is the TLD. There are generic TLDs (gTLDs) like .com (commercial), .org (organization), .edu (educational), .gov (government), etc., and country-code TLDs like .uk (United Kingdom), .ca (Canada), etc. ICANN administers the TLD system. In recent years, many new gTLDs have been introduced (e.g., .aero for the air-transport industry, .museum for museums, etc.), but .com, .org, .net remain the most common.'),
                'order_index' => 7,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.8 Markup Languages',
                'description' => 'SGML, HTML, XML, XHTML, and HTML5',
                'content' => $this->convertToHtml('**Markup languages** consist of sets of directions (tags) that tell browser software (and other user agents) how to display and manage content on a web page. Tim Berners-Lee used **Standard Generalized Markup Language (SGML)** to define HTML in the early 1990s. SGML is not a language itself, but a standard for specifying markup languages via document type definitions (DTDs).
**Hypertext Markup Language (HTML)** – HTML uses markup tags (e.g., <p>, <h1>, <img>) in a text file intended for display in a web browser. The browser interprets the tags to render the page\'s content and layout. The W3C maintains the HTML standard.
**Extensible Markup Language (XML)** – XML, developed by the W3C, is a flexible way to create common data formats and share data. It\'s a text-based syntax for marking up structured information (like a data file or feed). XML is not meant to replace HTML, but to complement it by separating content from presentation (e.g., RSS feeds are in XML). Developers can create custom tags in XML to describe their data.
**Extensible Hypertext Markup Language (XHTML)** – XHTML reformulated HTML4 as an XML application (with stricter rules). Many websites were coded in XHTML for a time. The W3C started an XHTML2.0 project, but it was discontinued in favor of HTML5, since XHTML2 wasn\'t backward-compatible with existing HTML4.
**HTML5** – HTML5 is the successor to HTML4/XHTML, combining features of both and adding new elements and APIs (like form enhancements, native video/audio, canvas, etc.) while remaining backward-compatible. HTML5 became a W3C Recommendation in 2014, and newer versions (HTML5.1, HTML5.2) have added even more features. Modern browsers largely support HTML5 and its updates.

*Checkpoint 1.2:*
1. Describe the components of the client/server model as applied to the Internet.
2. Identify two protocols used on the Internet that do not use the Web.
3. Explain the similarities and differences between a URL and a domain name.'),
                'order_index' => 8,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '1.9 Popular Uses of the Web',
                'description' => 'E-commerce, mobile access, blogs, wikis, social networking, cloud computing, RSS, and podcasts',
                'content' => $this->convertToHtml('The Web today is used for a variety of purposes, including:
- **E-Commerce:** Buying and selling goods/services online (online shopping). E-commerce has grown exponentially; studies show about 80% of American adults have made an online purchase. Sales in U.S. e-commerce are in the hundreds of billions annually. Importantly, e-commerce now happens across devices – not just on PCs but also on tablets, smartphones, or via voice assistants.
- **Mobile Access:** Accessing the Web via smartphones and tablets is extremely common. In fact, a significant percentage of people rely primarily on mobile devices for Internet access (some do not have desktop broadband at all). Web designers must use responsive design techniques so sites display and function well on small screens and touch interfaces as well as on larger monitors.
- **Blogs:** A blog is an online journal (web log) with posts (articles) displayed in chronological order. Blogs can be about any topic, from technology to personal diaries. They are easy to update using blog platforms (no advanced technical skill needed). Many companies also run blogs to connect with customers and provide updates.
- **Wikis:** A wiki is a collaborative website that can be directly edited by authorized users (or in the case of Wikipedia, by virtually anyone). Wikis allow many contributors to add or refine content collectively. Wikipedia, for example, is a massive encyclopedia written and edited by volunteers worldwide. While information on wikis should be double-checked for accuracy (due to open editing), they are a powerful way to gather and share community knowledge.
- **Social Networking:** Social media sites (Facebook, Twitter, Instagram, LinkedIn, etc.) have become integral to personal and professional communication. As of 2019, about 70% of U.S. adults use at least one social media platform. These sites allow people to share updates, photos, and links, and enable businesses to engage with customers. Facebook has over 2 billion monthly users globally. Twitter, a microblogging service (tweets are short messages up to 280 characters), is used by individuals and organizations to broadcast updates and interact. LinkedIn focuses on professional networking, while Instagram and Pinterest are popular for visual content and ideas. Social networking is a key aspect of modern web use.
- **Cloud Computing:** Many web services provide software and storage "in the cloud" (on remote servers). Examples include Google Drive or Microsoft OneDrive for documents and files, web-based email, and software-as-a-service (SaaS) applications. Instead of installing software or storing data on a local computer, users use a browser to access tools and data stored on the Internet. Cloud computing enables collaboration (multiple people working on a document online) and access to your data from any device. Its usage is expanding in both consumer and enterprise contexts.
- **RSS Feeds:** **Really Simple Syndication (RSS)** allows users to subscribe to updates from websites. Websites (like blogs or news sites) publish an RSS feed (XML format) listing their latest content headlines or summaries. Users run a **newsreader** (or feed reader) application or plugin which aggregates all their subscribed feeds and shows new posts in one place. This "pull" mechanism is a way for web developers to disseminate content to interested users without relying on them visiting the site directly every time.
- **Podcasts:** Podcasts are audio (or video) programs distributed via the web, often in an episodic series. They are usually delivered through an RSS feed as well, so users can subscribe and automatically get new episodes. A podcast might be like a radio show or lecture series that users can listen to on-demand on their phone or computer. Thousands of podcasts exist on every imaginable topic, and they contribute to the rich diversity of Web content.

**Constant Change:** Web technologies and trends evolve rapidly. New standards, tools, and user behaviors emerge all the time. Staying current is part of a web developer\'s life – for example, by reading articles, following blogs (like the textbook\'s companion website blog for Web trends), and practicing new techniques. The web development field requires continuous learning, as "the next big thing" can rise to prominence quickly.'),
                'order_index' => 9,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => 'Chapter 1 Summary & Key Terms',
                'description' => 'Review of Chapter 1 key concepts and terminology',
                'content' => 'This chapter provided a brief overview of Internet, Web, and networking concepts. Some information may have been familiar already. Visit the textbook\'s website for links to all URLs in this chapter and updated information.<br><br>Key Terms: accessible website; Americans with Disabilities Act (ADA); backbone; blog; client/server; clients; cloud computing; country-code top-level domain (ccTLD); Creative Commons; domain name; Domain Name System (DNS); e-commerce; extranet; File Transfer Protocol (FTP); fully qualified domain name (FQDN); generic top-level domain (gTLD); HTML5; Hypertext Markup Language (HTML); Hypertext Transfer Protocol (HTTP); Hypertext Transfer Protocol Secure (HTTPS); Internet; Internet Architecture Board (IAB); Internet Assigned Numbers Authority (IANA); Internet Corporation for Assigned Names and Numbers (ICANN); Internet Engineering Task Force (IETF); Internet Message Access Protocol (IMAP); intranet; IP; IP address; IP Version 4 (IPv4); IP Version 6 (IPv6); local area network (LAN); markup languages; microblogging; Multipurpose Internet Mail Extensions (MIME); network; newsreader; packets; podcasts; Post Office Protocol (POP3); protocols; Really Simple Syndication or Rich Site Summary (RSS); Request for Comments (RFC); Section 508 of the Federal Rehabilitation Act; server; Simple Mail Transfer Protocol (SMTP); social networking; Standard Generalized Markup Language (SGML); subdomain; TCP; Tim Berners-Lee; top-level domain (TLD); Transmission Control Protocol/Internet Protocol (TCP/IP); tweet; Uniform Resource Identifier (URI); Uniform Resource Locator (URL); universal design; Web Accessibility Initiative (WAI); Web Content Accessibility Guidelines (WCAG); web host server; wide area network (WAN); wiki; World Intellectual Property Organization (WIPO); World Wide Web; World Wide Web Consortium (W3C); XHTML; XML.',
                'order_index' => 10,
                'is_published' => true,
            ],
            // Chapter 2 lessons
            [
                'course_id' => $course->id,
                'title' => '2.1 HTML Overview',
                'description' => 'Introduction to HTML and its purpose',
                'content' => 'This lesson introduces the basics of HTML (HyperText Markup Language), the foundation of web pages. Students will learn what HTML is, its role in web development, and how browsers interpret HTML code to display web content.',
                'order_index' => 11,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.2 Document Type Definition',
                'description' => 'Understanding the DOCTYPE declaration',
                'content' => 'Learn about the Document Type Definition (DOCTYPE) and why it\'s essential for every HTML document. This lesson covers the HTML5 DOCTYPE declaration and its role in ensuring proper browser rendering.',
                'order_index' => 12,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.3 Web Page Template',
                'description' => 'Basic HTML document structure',
                'content' => 'Explore the fundamental structure of an HTML document, including the essential elements that form a complete web page template. Learn about the standard boilerplate code that every HTML page should contain.',
                'order_index' => 13,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.4 HTML Element',
                'description' => 'The root element of HTML documents',
                'content' => 'Understanding the <html> element as the root container for all other HTML elements. Learn about the lang attribute and its importance for accessibility and SEO.',
                'order_index' => 14,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.5 Head, Title, Meta, and Body Elements',
                'description' => 'Essential HTML document sections',
                'content' => 'Detailed exploration of the <head> section and its contents, including <title>, <meta> tags, and their purposes. Learn how the <body> element contains all visible content of a web page.',
                'order_index' => 15,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.6 Your First Web Page',
                'description' => 'Creating a simple HTML document',
                'content' => 'Hands-on lesson where students create their first complete HTML web page from scratch, applying all previously learned concepts.',
                'order_index' => 16,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.7 Heading Element',
                'description' => 'Using HTML heading tags effectively',
                'content' => 'Learn about the six levels of HTML headings (h1-h6), their semantic importance, and best practices for creating a proper document outline.',
                'order_index' => 17,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.8 Paragraph Element',
                'description' => 'Structuring text content with paragraphs',
                'content' => 'Understanding the <p> element for creating paragraphs and organizing text content effectively on web pages.',
                'order_index' => 18,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.9 Line Break Element',
                'description' => 'Controlling line breaks in HTML',
                'content' => 'Learn when and how to use the <br> element for line breaks, and understand the difference between line breaks and paragraph separation.',
                'order_index' => 19,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.10 Blockquote Element',
                'description' => 'Marking up quotations in HTML',
                'content' => 'Using the <blockquote> element for extended quotations and understanding its semantic meaning and default styling.',
                'order_index' => 20,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.11 Phrase Elements',
                'description' => 'Inline text formatting elements',
                'content' => 'Explore phrase elements like <strong>, <em>, <cite>, <code>, and others for adding semantic meaning and formatting to inline text.',
                'order_index' => 21,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.12 Ordered List',
                'description' => 'Creating numbered lists in HTML',
                'content' => 'Learn how to create ordered (numbered) lists using <ol> and <li> elements, including different numbering styles and nested lists.',
                'order_index' => 22,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.13 Unordered List',
                'description' => 'Creating bulleted lists in HTML',
                'content' => 'Master the creation of unordered (bulleted) lists using <ul> and <li> elements, including styling options and nesting.',
                'order_index' => 23,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.14 Description List',
                'description' => 'Creating definition lists',
                'content' => 'Understanding description lists (<dl>, <dt>, <dd>) for creating term-definition pairs and other related content structures.',
                'order_index' => 24,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.15 Special Characters',
                'description' => 'HTML entities and special symbols',
                'content' => 'Learn about HTML entities for displaying special characters, including copyright symbols, quotes, and other symbols that have special meaning in HTML.',
                'order_index' => 25,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.16 Structural Elements',
                'description' => 'HTML5 semantic structural elements',
                'content' => 'Explore HTML5 semantic elements like <header>, <nav>, <main>, <section>, <article>, <aside>, and <footer> for better document structure.',
                'order_index' => 26,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.17 Hyperlinks',
                'description' => 'Creating links between pages and resources',
                'content' => 'Master the anchor (<a>) element for creating hyperlinks, including internal links, external links, email links, and anchor links within a page.',
                'order_index' => 27,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => '2.18 HTML Validation',
                'description' => 'Validating HTML code for standards compliance',
                'content' => 'Learn the importance of HTML validation, how to use validation tools, and how to fix common validation errors.',
                'order_index' => 28,
                'is_published' => true,
            ],
            [
                'course_id' => $course->id,
                'title' => 'Chapter 2 Summary & Key Terms',
                'description' => 'Review of Chapter 2 HTML basics',
                'content' => 'Summary of all HTML elements and concepts covered in Chapter 2, including a comprehensive list of key terms and their definitions.',
                'order_index' => 29,
                'is_published' => true,
            ],
        ];

        foreach ($lessons as $lessonData) {
            // Generate slug if not provided
            if (!isset($lessonData['slug'])) {
                $lessonData['slug'] = Str::slug($lessonData['title']);
            }
            
                $lesson = Lesson::firstOrCreate(
                    [
                        'course_id' => $lessonData['course_id'],
                        'slug' => $lessonData['slug']
                    ],
                    $lessonData
                );
                
                if ($lesson->wasRecentlyCreated) {
                    $this->command->info("Created lesson: {$lesson->title}");
                } else {
                    $this->command->info("Lesson already exists: {$lesson->title}");
                }
        }

        $this->command->info('All HTML5 lessons created successfully.');
    }

    /**
     * Convert markdown-style bold to HTML
     */
    private function convertToHtml($content)
    {
        // Convert **text** to <strong>text</strong>
        $content = preg_replace('/\*\*([^\*]+)\*\*/i', '<strong>$1</strong>', $content);
        
        // Convert newlines to <br> tags where appropriate
        $content = str_replace("\n\n", '</p><p>', $content);
        $content = str_replace("\n", '<br>', $content);
        
        // Wrap in paragraph tags if not already wrapped
        if (!str_starts_with($content, '<p>')) {
            $content = '<p>' . $content . '</p>';
        }
        
        return $content;
    }
}

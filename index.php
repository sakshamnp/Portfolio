
<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

/* =========================================
   1. SOCIAL LINKS
========================================= */
$socials = [
    [
        'platform' => '  GitHub',
        'url' => 'https://github.com/sakshamnp',
        'icon_text' => 'GH'
    ],
    [
        'platform' => '  LinkedIn',
        'url' => 'https://www.linkedin.com/in/sakshambhandarinp/',
        'icon_text' => 'in'
    ]
];

/* =========================================
   2. LOAD PORTFOLIO DATA
========================================= */
$profile = $pdo->query(
    'SELECT * FROM personal_details ORDER BY id LIMIT 1'
)->fetch() ?: [];

$education = $pdo->query(
    'SELECT * FROM education ORDER BY sort_order, start_year DESC'
)->fetchAll();

$skills = $pdo->query(
    'SELECT * FROM skills ORDER BY category, sort_order, name'
)->fetchAll();

$projects = $pdo->query(
    'SELECT * FROM projects WHERE is_published = 1 ORDER BY sort_order, id'
)->fetchAll();

$achievements = $pdo->query(
    'SELECT * FROM achievements
     WHERE is_published = 1
     ORDER BY sort_order, achievement_date DESC'
)->fetchAll();

$connectUrl = setting($pdo, 'tilottama_connect_url', '');

$pageTitle = 'Saksham Bhandari | Computer Engineering Student & Developer';

$metaDescription = 'Portfolio of Saksham Bhandari, Computer Engineering student at Kathmandu University, Nepal. Explore skills, projects, education, and contact information.';

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<main>

    <!-- =====================================
         HERO
    ====================================== -->
    <section class="hero section-wrap" id="home">

        <div class="hero-copy">
            <span class="eyebrow">
                <span class="status-dot"></span>
                Computer Engineering Student · Nepal
            </span>

            <h1>
                Building ideas into
                <span class="accent-text">useful technology.</span>
            </h1>

            <p class="hero-intro">
                I'm <strong>Saksham Bhandari</strong>, a Computer Engineering
                student at Kathmandu University, Nepal, interested in
                programming, web development, problem-solving, and building
                practical digital solutions.
            </p>

            <div class="hero-actions">
                <a class="button button-primary" href="#projects">
                    Explore My Projects <span aria-hidden="true">↗</span>
                </a>

                <a class="button button-secondary" href="#contact">
                    Contact Me
                </a>
            </div>

            <div class="hero-socials" aria-label="Social profiles">
                <?php foreach ($socials as $social): ?>
                    <a
                        href="<?= e($social['url']) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="<?= e($social['platform']) ?> profile"
                    >
                        <?= e($social['platform']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Real portrait instead of the fake code window -->
        <div class="hero-art">
            <div class="photo-glow"></div>

            <div class="photo-frame">
                    <img src="assets/images/profile.jpg"
                        alt="Saksham Bhandari"
                        class="profile-photo">        
                        </div>

            <div class="floating-chip chip-top">
                &lt;/&gt; Learn · Build · Repeat
            </div>

            <div class="floating-chip chip-bottom">
                <span class="status-dot"></span>
                Open to learning
            </div>
        </div>

        <a class="scroll-cue" href="#about">
            <span></span>
            Scroll to explore
        </a>
 
    </section>


    <!-- =====================================
         ABOUT
    ====================================== -->
    <section class="section-wrap section" id="about">

        <div class="section-heading">
            <span class="eyebrow">A little about me</span>

            <h2>
                Curious by nature.<br>
                <span class="muted-heading">Builder by practice.</span>
            </h2>
        </div>

        <div class="about-grid">

            <div class="about-copy">
                <p>
                    <?= e($profile['biography'] ??
                        'I am a Computer Engineering student who enjoys exploring technology and developing practical software projects. My interests include programming, web development, and creating digital solutions that address real-world needs. Through academic projects and independent learning, I am continuously developing my technical skills and expanding my understanding of software development.'
                    ) ?>
                </p>

                <p>
                    I believe the best way to learn technology is to use it:
                    experiment, build something, discover what breaks, and
                    improve it.
                </p>

                <!-- <div class="interest-list">
                    <span>⌘ Programming</span>
                    <span>↗ Building projects</span>
                    <span>✳ Learning new tech</span>
                    <span>⌕ Problem-solving</span>
                </div> -->
            </div>

            <div class="detail-card">
                <div class="detail-row">
                    <span>Currently</span>
                    <strong>Undergraduate student</strong>
                </div>

                <div class="detail-row">
                    <span>University</span>
                    <strong>Kathmandu University</strong>
                </div>

                <div class="detail-row">
                    <span>Degree</span>
                    <strong>Bachelor in Computer Engineering</strong>
                </div>

                <div class="detail-row">
                    <span>Based in</span>
                    <strong>Nepal</strong>
                </div>

                <div class="detail-row">
                    <span>Expected graduation</span>
                    <strong>2030</strong>
                </div>
            </div>

        </div>
    </section>


    <!-- =====================================
         EDUCATION
    ====================================== -->
    <section class="section section-alt" id="education">

        <div class="section-wrap">

            <div class="section-heading">
                <span class="eyebrow">The learning journey</span>
                <h2>Education</h2>
                <p>From school foundations to engineering and beyond.</p>
            </div>

            <div class="education-list">

                <?php foreach ($education as $edu): ?>
                    <article class="education-card">

                        <div class="institution-logo">
                            <img
                                src="<?= e($edu['logo_url'] ?? '') ?>"
                                alt="<?= e($edu['institution'] ?? 'Institution') ?> logo"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='assets/images/institution-placeholder.svg';"
                            >
                        </div>

                        <div class="education-content">

                            <div class="education-top">
                                <div>
                                    <h3>
                                        <?= e($edu['institution'] ?? '') ?>
                                    </h3>

                                    <p class="education-qualification">
                                        <?= e($edu['qualification'] ?? '') ?>
                                    </p>
                                </div>

                                <span class="date-pill">
                                    <?= e($edu['period_label'] ?? '') ?>
                                </span>
                            </div>

                            <p class="location-line">
                                ⌖ <?= e($edu['location'] ?? '') ?>
                            </p>

                            <p>
                                <?= e($edu['description'] ?? '') ?>
                            </p>

                        </div>
                    </article>
                <?php endforeach; ?>

            </div>
        </div>
    </section>


    <!-- =====================================
         SKILLS
    ====================================== -->
    
                <section class="section section-wrap" id="skills">

                    <div class="section-heading">
                        <span class="eyebrow">Tools in my toolbox</span>
                        <h2>Skills &amp; Technologies</h2>
                        <p>A growing set of tools I use while learning and building.</p>
                    </div>

                    <!-- PROGRAMMING LANGUAGES -->
                    <div class="skill-group">
                        <h3>Programming Languages</h3>

                        <div class="skills-grid">

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/c/c-original.svg" alt="C">
                                </div>
                                <div>
                                    <h4>C</h4>
                                    <p>Programming fundamentals and problem-solving.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/python/python-original.svg" alt="Python">
                                </div>
                                <div>
                                    <h4>Python</h4>
                                    <p>Scripting, functions, and programming concepts.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg" alt="JavaScript">
                                </div>
                                <div>
                                    <h4>JavaScript</h4>
                                    <p>Interactive websites and dynamic functionality.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg" alt="PHP">
                                </div>
                                <div>
                                    <h4>PHP</h4>
                                    <p>Server-side programming and web development.</p>
                                </div>
                            </article>

                        </div>
                    </div>

                    <!-- WEB DEVELOPMENT -->
                    <div class="skill-group">
                        <h3>Web Development</h3>

                        <div class="skills-grid">

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg" alt="HTML5">
                                </div>
                                <div>
                                    <h4>HTML5</h4>
                                    <p>Building structured and accessible web pages.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg" alt="CSS3">
                                </div>
                                <div>
                                    <h4>CSS3</h4>
                                    <p>Styling websites and responsive layouts.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg" alt="MySQL">
                                </div>
                                <div>
                                    <h4>MySQL</h4>
                                    <p>Database management and SQL queries.</p>
                                </div>
                            </article>

                        </div>
                    </div>

                    <!-- DEVELOPMENT TOOLS -->
                    <div class="skill-group">
                        <h3>Development Tools</h3>

                        <div class="skills-grid">

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://www.apachefriends.org/images/xampp-logo-ac950edf.svg" alt="XAMPP">
                                </div>
                                <div>
                                    <h4>XAMPP</h4>
                                    <p>Local development using Apache, PHP, and MySQL.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vscode/vscode-original.svg" alt="VS Code">
                                </div>
                                <div>
                                    <h4>VS Code</h4>
                                    <p>Writing, editing, and debugging code.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg" alt="Git">
                                </div>
                                <div>
                                    <h4>Git</h4>
                                    <p>Version control and tracking code changes.</p>
                                </div>
                            </article>

                            <article class="skill-card">
                                <div class="skill-icon">
                                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/github/github-original.svg" alt="GitHub">
                                </div>
                                <div>
                                    <h4>GitHub</h4>
                                    <p>Hosting repositories and managing projects.</p>
                                </div>
                            </article>

                        </div>
                    </div>

                </section>


        

    


    <!-- =====================================
         PROJECTS
    ====================================== -->
    <section class="section section-alt" id="projects">

        <div class="section-wrap">

            <div class="section-heading heading-row">

                <div>
                    <span class="eyebrow">Selected work</span>
                    <h2>Projects</h2>
                    <p>
                        Academic work and ideas built around practical problems.
                    </p>
                </div>

                <a class="text-link" href="projects.php">
                    Project details <span>↗</span>
                </a>

            </div>

            <div class="projects-grid">

                <?php foreach ($projects as $project): ?>

                    <?php
                    $isConnect = stripos(
                        $project['title'] ?? '',
                        'Tilottama Connect'
                    ) !== false;

                    $url = $isConnect
                        ? $connectUrl
                        : ($project['website_url'] ?? '');
                    ?>

                    <article class="project-card">

                        <a
                            class="project-visual <?= e($project['visual_class'] ?? '') ?>"
                            href="projects.php?id=<?= (int) $project['id'] ?>"
                            aria-label="View details for <?= e($project['title'] ?? 'project') ?>"
                        >

                            <?php
                            $title = $project['title'] ?? '';

                            if (stripos($title, 'HORIZ.ONE') !== false) {
                                $imagePath = 'assets/images/01.png';
                            } elseif (stripos($title, 'Tilottama Connect') !== false) {
                                $imagePath = 'assets/images/02.png';
                            } else {
                                $imagePath = $project['screenshot_path'] ?? '';
                            }
                            ?>

                            <?php if (!empty($imagePath)): ?>
                                <img
                                    src="<?= e($imagePath) ?>"
                                    alt="<?= e($title ?: 'Project') ?> preview"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                                >

                                <div class="project-placeholder" style="display:none">
                                    <span><?= e($project['monogram'] ?? '+') ?></span>
                                    <small><?= e($project['category'] ?? '') ?></small>
                                </div>
                            <?php else: ?>
                                <div class="project-placeholder">
                                    <span><?= e($project['monogram'] ?? '+') ?></span>
                                    <small><?= e($project['category'] ?? '') ?></small>
                                </div>
                            <?php endif; ?>

                         </a>

                        <div class="project-body">

                            <div class="project-meta">
                                <span><?= e($project['category'] ?? '') ?></span>
                                <span><?= e($project['context_label'] ?? '') ?></span>
                            </div>

                            <h3><?= e($project['title'] ?? '') ?></h3>

                            <p>
                                <?= e($project['short_description'] ?? '') ?>
                            </p>

                            <div class="tag-list">
                                <?php
                                $tags = explode(
                                    ',',
                                    $project['technology_tags'] ?? ''
                                );
                                ?>

                                <?php foreach ($tags as $tag): ?>
                                    <?php if (trim($tag) !== ''): ?>
                                        <span><?= e(trim($tag)) ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="project-links">

                                <a
                                    class="text-link"
                                    href="projects.php?id=<?= (int) $project['id'] ?>"
                                >
                                    View details <span>↗</span>
                                </a>

                                <?php if (!empty($url)): ?>

                                    <a
                                        class="icon-link"
                                        href="<?= e($url) ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        Live website ↗
                                    </a>

                                <?php elseif ($isConnect): ?>

                                    <span class="coming-soon">
                                        Website link coming soon
                                    </span>

                                <?php endif; ?>

                            </div>
                        </div>
                    </article>

                <?php endforeach; ?>


                <article class="project-card project-coming">

                    <div class="project-placeholder future-placeholder">
                        <span>+</span>
                        <small>Next up</small>
                    </div>

                    <div class="project-body">

                        <div class="project-meta">
                            <span>In progress</span>
                        </div>

                        <h3>More projects coming soon</h3>

                        <p>
                            As I learn and build more, this space will grow
                            with new experiments and practical solutions.
                        </p>

                        <div class="tag-list">
                            <span>Keep learning</span>
                            <span>Keep building</span>
                        </div>

                    </div>
                </article>

            </div>
        </div>
    </section>


    <!-- =====================================
         ACHIEVEMENTS
    ====================================== -->
    <section class="section section-wrap" id="achievements">

        <div class="section-heading">
            <span class="eyebrow">Milestones</span>
            <h2>Achievements &amp; certificates</h2>
            <p>
                Selected learning milestones will be added here as they
                are documented.
            </p>
        </div>

        <?php if (!empty($achievements)): ?>

            <div class="achievement-grid">

                <?php foreach ($achievements as $achievement): ?>
                    <article class="achievement-card">

                        <span class="achievement-mark">✦</span>

                        <div>
                            <h3><?= e($achievement['title'] ?? '') ?></h3>

                            <p>
                                <?= e($achievement['description'] ?? '') ?>
                            </p>

                            <small>
                                <?= e(
                                    $achievement['achievement_date']
                                    ?: 'Date not specified'
                                ) ?>
                            </small>

                            <?php if (!empty($achievement['certificate_url'])): ?>
                                <a
                                    class="text-link"
                                    href="<?= e($achievement['certificate_url']) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    View certificate ↗
                                </a>
                            <?php endif; ?>
                        </div>

                    </article>
                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-state">
                <span>✳</span>
                <p>
                    Learning is ongoing. Verified certificates and
                    achievements will appear here when added.
                </p>
            </div>

        <?php endif; ?>

    </section>


    <!-- =====================================
         CONTACT
    ====================================== -->
    <section class="section contact-section" id="contact">

        <div class="section-wrap">

            <div class="section-heading">
                <span class="eyebrow">Let's connect</span>

                <h2>
                    Have an idea?<br>
                    <span class="muted-heading">Let's talk about it.</span>
                </h2>

                <p>
                    For project discussions, collaboration, or a friendly
                    conversation about technology.
                </p>
            </div>

            <div class="contact-grid">

                <div class="contact-info">

                    <a
                        class="email-card"
                        href="mailto:sakshambhandari.np@gmail.com"
                    >

                        <span class="email-icon gmail-icon">
                            <img
                                src="https://upload.wikimedia.org/wikipedia/commons/8/8f/Gmail_icon_%282026%29.svg?utm_source=en.wikipedia.org&utm_campaign=index&utm_content=original?"
                                width="30" height="30"
                                alt="Gmail"
                            >
                        </span>

                        <span>
                            <small>Email me at</small>
                            <strong>sakshambhandari.np@gmail.com</strong>
                        </span>

                        <span class="arrow">↗</span>
                    </a>

                    <button
                        type="button"
                        class="copy-email"
                        id="copyEmail"
                        data-email="sakshambhandari.np@gmail.com"
                    >
                        Copy email <span>▣</span>
                    </button>

                    <p
                        class="copy-feedback"
                        id="copyFeedback"
                        aria-live="polite"
                    ></p>

                  
                        <div class="social-grid">

                            <a href="https://www.facebook.com/sakshambhandari.np"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Facebook profile">
                                <span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/5968/5968764.png"
                                        alt="Facebook" width="24" height="24">
                                </span>
                                  Facebook
                                <b>↗</b>
                            </a>

                            <a href="https://www.instagram.com/_saksham.np"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="Instagram profile">
                                <span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png"
                                        alt="Instagram" width="24" height="24">
                                </span>
                                Instagram
                                <b>↗</b>
                            </a>

                            <a href="https://github.com/sakshamnp"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="GitHub profile">
                                <span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/25/25231.png"
                                        alt="GitHub" width="24" height="24">
                                </span>
                                GitHub
                                <b>↗</b>
                            </a>

                            <a href="https://www.linkedin.com/in/sakshambhandarinp/"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="LinkedIn profile">
                                <span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/3536/3536505.png"
                                        alt="LinkedIn" width="24" height="24">
                                </span>
                                LinkedIn
                                <b>↗</b>
                            </a>

                            <a href="https://x.com/Saksham83826044"
                            target="_blank" rel="noopener noreferrer"
                            aria-label="X profile">
                                <span>
                                    <img src="https://cdn-icons-png.flaticon.com/512/5968/5968958.png"
                                        alt="X" width="24" height="24">
                                </span>
                                X
                                <b>↗</b>
                            </a>

                        </div>

                </div>


                <form
                    class="contact-form"
                    action="submit_contact.php"
                    method="post"
                >

                    <input
                        type="hidden"
                        name="csrf_token"
                        value="<?= e(csrf_token()) ?>"
                    >

                    <div class="honeypot" aria-hidden="true">
                        <label>
                            Leave this empty
                            <input
                                type="text"
                                name="website"
                                tabindex="-1"
                                autocomplete="off"
                            >
                        </label>
                    </div>

                    <div class="form-row">
                        <label for="name">Your name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            maxlength="100"
                            required
                            autocomplete="name"
                            placeholder="Name"
                        >
                    </div>

                    <div class="form-row">
                        <label for="email">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            maxlength="254"
                            required
                            autocomplete="email"
                            placeholder="you@example.com"
                        >
                    </div>

                    <div class="form-row">
                        <label for="subject">Subject</label>
                        <input
                            id="subject"
                            name="subject"
                            type="text"
                            maxlength="150"
                            required
                            placeholder="What is this about?"
                        >
                    </div>

                    <div class="form-row">
                        <label for="message">Message</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="2"
                            maxlength="5000"
                            required
                            placeholder="Tell me a little about it..."
                        ></textarea>
                    </div>

                    <button
                        class="button button-primary submit-button"
                        type="submit"
                    >
                        Send message <span>↗</span>
                    </button>

                    <p class="form-note">
                        
                        Email delivery is not enabled by default.
                    </p>

                </form>

            </div>
        </div>
    </section>

</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

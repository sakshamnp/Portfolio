<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$project = null;

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM projects WHERE id = ? AND is_published = 1');
    $stmt->execute([$id]);
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
}

$projects = $pdo->query(
    'SELECT * FROM projects WHERE is_published = 1 ORDER BY sort_order, id'
)->fetchAll(PDO::FETCH_ASSOC);

if ($id && !$project) {
    http_response_code(404);
}

$pageTitle = $project ? $project['title'] . ' | Saksham Bhandari' : 'Projects | Saksham Bhandari';
$metaDescription = $project
    ? ($project['short_description'] ?? '')
    : 'Academic projects and practical technology experiments by Saksham Bhandari.';

$isHorizone = $project && stripos($project['title'], 'HORIZ.ONE') !== false;
$isTilottama = $project && stripos($project['title'], 'Tilottama Connect') !== false;

// Shared structure, project-specific content.
$details = null;
if ($isHorizone) {
    $details = [
        'overview' => 'HORIZ.ONE is a user-friendly school management and learning platform developed by Team Iconic. It connects students, teachers, and school administration in one digital space, bringing quizzes, leaderboards, notices, class forums, fee status, library information, past papers, digital IDs, and teaching tools together.',
        'features' => [
            ['📝', 'Daily MCQs', 'Interactive daily quizzes for regular learning and revision.'],
            ['🏆', 'Leaderboard', 'Student rankings that recognize achievements and participation.'],
            ['📐', 'LaTeX Tool', 'Tools for preparing mathematical and academic content.'],
            ['💬', 'Class Forum', 'A space for students and teachers to communicate.'],
            ['💳', 'Fee Status', 'Convenient access to school fee information.'],
            ['📚', 'Library Information', 'Access to school library resources and information.'],
            ['📄', 'Past Papers', 'Previous examination papers for revision.'],
            ['🪪', 'Digital ID', 'Student identification within the platform.'],
            ['⚡', 'MCQ Battle', 'Competitive quizzes that make learning engaging.'],
        ],
        'technologies' => [
            ['HTML', 'html5/html5-original.svg', 'Website structure and content.'],
            ['CSS', 'css3/css3-original.svg', 'Layout, styling, and responsiveness.'],
            ['PHP', 'php/php-original.svg', 'Backend logic and user management.'],
            ['SQL', 'azuresqldatabase/azuresqldatabase-original.svg', 'Data storage and retrieval.'],
        ],
        'benefits_title' => 'Why HORIZ.ONE?',
        'benefits' => [
            ['Better Learning', 'Quizzes, rankings, and MCQ battles encourage regular practice.'],
            ['Efficient Teaching', 'MCQ creation and OMR checking tools support assessment.'],
            ['Easy Management', 'Fee status, notices, and library information simplify school activities.'],
            ['Improved Communication', 'Class forums and notices connect students and teachers.'],
            ['Centralized Resources', 'Past papers, digital IDs, and academic records in one place.'],
            ['Student Recognition', 'Leaderboards celebrate academic achievements.'],
        ],
        'gallery' => [
            ['01.png', 'Login Page'],
            ['02.png', 'Student Sign-up'],
            ['T01.png', 'Teacher Sign-up'],
            ['S1.png', 'Student Dashboard'],
            ['S2.png', 'Student Dashboard'],
            ['T02.png', 'Teacher Dashboard'],
            ['T03.png', 'Teacher Dashboard'],
            ['03.png', 'HORIZ.ONE Quiz'],
            ['04.png', 'MCQ Battle Area'],
            ['05.png', 'MCQ Battle Area'],
            ['06.png', 'MCQ Battle Area'],
            ['07.png', 'QuestHub'],
            ['08.png', 'QuestHub'],
            ['09.png', 'Marksheet'],
        ],
        'future' => [
            ['🤖', 'Global AI Analysis', 'AI-assisted analysis and feedback across the platform.'],
            ['🎥', 'Virtual Meetings', 'Online meetings for students and teachers.'],
            ['✍️', 'Teachers & Alumni Blogs', 'A place to share articles, guidance, and exam advice.'],
        ],
    ];
} elseif ($isTilottama) {
    $details = [
        'overview' => 'Tilottama Connect is a user-friendly community website proposed by Team Tilians to connect Tilottama residents with one another, the local government, and other local entities. It brings municipal information, community discussion, local updates, and practical services into one digital platform.',
        'features' => [
            ['📢', 'Notices (N.o.W)', 'Municipal notices and important local announcements.'],
            ['🌤️', 'Weather', 'Weather information relevant to local residents.'],
            ['📅', 'Events', 'Information about local events and activities.'],
            ['💬', 'Forum', 'Community discussion and interaction between residents.'],
            ['✍️', 'Blog', 'A space for local articles and community voices.'],
            ['🚛', 'Truck Route', 'Information about municipal truck routes.'],
            ['📰', 'News', 'Updates and news related to the municipality.'],
            ['📣', 'Promotional Banners', 'Space for local promotions and announcements.'],
            ['🤖', 'Tilu AI', 'An assistant intended to answer municipal questions in Nepali and English.'],
        ],
        'technologies' => [
            ['HTML', 'html5/html5-original.svg', 'Structures the website and its content.'],
            ['CSS', 'css3/css3-original.svg', 'Controls the design and responsive layout.'],
        ],
        'benefits_title' => 'Why Tilottama Connect?',
        'benefits' => [
            ['Community Connection', 'Encourages communication and collaboration among residents.'],
            ['Information in One Place', 'Makes municipal news, notices, and updates easier to find.'],
            ['Bilingual AI Assistance', 'Tilu AI is designed to support questions in Nepali and English.'],
            ['Local Awareness', 'Weather, events, and news help residents stay informed.'],
            ['Community Participation', 'Forums and blogs create opportunities to share ideas.'],
            ['Everyday Convenience', 'Organizes useful local information in a single website.'],
        ],
        // Add actual Tilottama screenshots here once you have exported them.
        // Example: ['tilottama-home.png', 'Home Page']
        'gallery' => [],
        'future' => [
            ['📍', 'GPS & Truck Tracking', 'Real-time navigation within the municipality and possible tracking of dump trucks on a map.'],
            ['🏛️', 'E-Governance', 'Potential collaboration with local government for online forms and municipal services.'],
            ['🏪', 'Local Utility Directory', 'Search for restaurants, shops, products, and services within the municipality.'],
        ],
    ];
}

include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/navbar.php';
?>

<style>
.tilottama-photo-placeholder {
    min-height: 210px;
    border: 2px dashed #b8c5d3;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background: rgba(128, 145, 166, 0.07);
    color: #748296;
    text-align: center;
    padding: 20px;
}
.tilottama-photo-placeholder span { font-size: 36px; }
.tilottama-photo-placeholder strong { font-size: 14px; }
</style>

<main class="section-wrap inner-page">
    <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="index.php">Home</a><span>/</span>
        <a href="projects.php">Projects</a>
        <?php if ($project): ?><span>/</span><span><?= e($project['title']) ?></span><?php endif; ?>
    </nav>

    <?php if ($project): ?>
        <?php
        $title = $project['title'];
        $websiteUrl = $isTilottama
            ? setting($pdo, 'tilottama_connect_url', '')
            : ($project['website_url'] ?? '');
        ?>
        <article class="project-detail">
            <div class="project-detail-actions project-detail-actions-top">
                <?php if ($websiteUrl): ?>
                    <a class="button button-primary" href="<?= e($websiteUrl) ?>" target="_blank" rel="noopener noreferrer">Visit Live Website ↗</a>
                <?php elseif ($isTilottama): ?>
                    <span class="coming-soon">Website link coming soon</span>
                <?php endif; ?>
                <?php if (!empty($project['repository_url'])): ?>
                    <a class="button button-secondary" href="<?= e($project['repository_url']) ?>" target="_blank" rel="noopener noreferrer">View Source Code ↗</a>
                <?php endif; ?>
                <a class="button button-secondary" href="projects.php">All Projects</a>
            </div>

            <header class="project-detail-heading">
                <span class="eyebrow"><?= e($project['category']) ?> · <?= e($project['context_label']) ?></span>
                <h1><?= e($title) ?></h1>
                <p class="project-lead"><?= e($project['short_description']) ?></p>
            </header>

            <?php if (!$details): ?>
                <div class="detail-visual <?= e($project['visual_class']) ?>">
                    <div class="project-placeholder">
                        <span><?= e($project['monogram']) ?></span>
                        <small><?= e($project['category']) ?></small>
                    </div>
                </div>
            <?php endif; ?>

            <div class="detail-content">
                <section class="detail-section">
                    <h2>Project Overview</h2>
                    <p><?= e($details['overview'] ?? ($project['description'] ?? '')) ?></p>
                </section>

                <?php if ($details): ?>
                    <section class="detail-section">
                        <h2>Key Features</h2>
                        <p>Explore the major features of <?= e($title) ?>.</p>
                        <div class="horizone-feature-grid">
                            <?php foreach ($details['features'] as $feature): ?>
                                <div class="horizone-feature">
                                    <span><?= e($feature[0]) ?></span>
                                    <h3><?= e($feature[1]) ?></h3>
                                    <p><?= e($feature[2]) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section class="detail-section">
                        <h2>Technologies Used</h2>
                        <p>Technologies documented for <?= e($title) ?>.</p>
                        <div class="horizone-tech-grid">
                            <?php foreach ($details['technologies'] as $tech): ?>
                                <div class="horizone-tech-card">
                                    <img src="<?= e('https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/' . $tech[1]) ?>" alt="<?= e($tech[0]) ?> logo" loading="lazy">
                                    <h3><?= e($tech[0]) ?></h3>
                                    <p><?= e($tech[2]) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section class="detail-section">
                        <h2><?= e($details['benefits_title']) ?></h2>
                        <div class="horizone-benefits">
                            <?php foreach ($details['benefits'] as $benefit): ?>
                                <div>
                                    <h3><?= e($benefit[0]) ?></h3>
                                    <p><?= e($benefit[1]) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>

                    <section class="detail-section">
                            <h2>Project Gallery</h2>
                            <p class="gallery-description">Screenshots showcasing <?= e($title) ?>.</p>
                            <div class="horizone-gallery">
                                <?php foreach ($details['gallery'] as $entry): ?>
                                    <?php $imagePath = 'assets/images/' . $entry[0]; ?>
                                    <figure class="gallery-item">
                                        <a href="<?= e($imagePath) ?>" target="_blank" rel="noopener noreferrer">
                                            <img src="<?= e($imagePath) ?>" alt="<?= e($entry[1]) ?>" loading="lazy">
                                        </a>
                                        <figcaption><?= e($entry[1]) ?></figcaption>
                                    </figure>
                                <?php endforeach; ?>
                                <?php if (empty($details['gallery'])): ?>
                                    <?php foreach (['Home Page', 'Weather & Notices', 'Community Forum', 'Local News & Events', 'Truck Route', 'Tilu AI'] as $label): ?>
                                        <figure class="gallery-item">
                                            <div class="tilottama-photo-placeholder" aria-label="Screenshot placeholder: <?= e($label) ?>">
                                                <span aria-hidden="true">📷</span>
                                                <strong>Screenshot coming soon</strong>
                                            </div>
                                            <figcaption><?= e($label) ?></figcaption>
                                        </figure>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </section>

                        <?php if (!empty($details['gallery'])): ?>
                        <div class="gallery-lightbox" id="galleryLightbox" role="dialog" aria-modal="true" aria-label="Project screenshot viewer" aria-hidden="true">
                            <button class="lightbox-close" id="lightboxClose" aria-label="Close image viewer">&times;</button>
                            <button class="lightbox-arrow lightbox-prev" id="lightboxPrev" aria-label="Previous image">&#10094;</button>
                            <div class="lightbox-content">
                                <img id="lightboxImage" src="" alt="Project screenshot">
                                <p id="lightboxCaption"></p>
                            </div>
                            <button class="lightbox-arrow lightbox-next" id="lightboxNext" aria-label="Next image">&#10095;</button>
                            <div class="lightbox-counter" id="lightboxCounter"></div>
                        </div>
                        <?php endif; ?>

                    <section class="detail-section">
                        <h2>Future Improvements</h2>
                        <p>Potential upgrades proposed for <?= e($title) ?>.</p>
                        <div class="horizone-future-grid">
                            <?php foreach ($details['future'] as $future): ?>
                                <div class="horizone-future-card">
                                    <span><?= e($future[0]) ?></span>
                                    <h3><?= e($future[1]) ?></h3>
                                    <p><?= e($future[2]) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php else: ?>
                    <section class="detail-section">
                        <h2>Purpose</h2>
                        <p><?= e($project['purpose'] ?? '') ?></p>
                    </section>
                <?php endif; ?>
            </div>
        </article>

    <?php elseif (!$id): ?>
        <header class="section-heading inner-heading">
            <span class="eyebrow">SELECTED WORK</span>
            <h1>My Projects</h1>
            <p>Academic projects and ideas focused on practical digital solutions, technology, and problem-solving.</p>
        </header>
        <div class="projects-grid">
            <?php foreach ($projects as $p): ?>
                <article class="project-card">
                    <a class="project-visual <?= e($p['visual_class']) ?>" href="projects.php?id=<?= (int) $p['id'] ?>" aria-label="View <?= e($p['title']) ?> details">
                        <div class="project-placeholder">
                            <span><?= e($p['monogram']) ?></span>
                            <small><?= e($p['category']) ?></small>
                        </div>
                    </a>
                    <div class="project-body">
                        <div class="project-meta"><span><?= e($p['category']) ?></span><span><?= e($p['context_label']) ?></span></div>
                        <h2><?= e($p['title']) ?></h2>
                        <p><?= e($p['short_description']) ?></p>
                        <div class="tag-list">
                            <?php foreach (explode(',', $p['technology_tags'] ?? '') as $tag): ?>
                                <?php if (trim($tag) !== ''): ?><span><?= e(trim($tag)) ?></span><?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <a class="text-link" href="projects.php?id=<?= (int) $p['id'] ?>">View Details ↗</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <section class="detail-section">
            <h1>Project Not Found</h1>
            <p>This project does not exist or is not currently published.</p>
            <a class="button button-primary" href="projects.php">Back to Projects</a>
        </section>
    <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = Array.from(document.querySelectorAll('.horizone-gallery .gallery-item a'));
    const lightbox = document.getElementById('galleryLightbox');
    if (!links.length || !lightbox) return;

    const image = document.getElementById('lightboxImage');
    const caption = document.getElementById('lightboxCaption');
    const counter = document.getElementById('lightboxCounter');
    const close = document.getElementById('lightboxClose');
    const prev = document.getElementById('lightboxPrev');
    const next = document.getElementById('lightboxNext');
    let index = 0;
    let lastFocus = null;

    function showImage(i) {
        index = (i + links.length) % links.length;
        const thumbnail = links[index].querySelector('img');
        image.src = links[index].href;
        image.alt = thumbnail ? thumbnail.alt : 'Project screenshot';
        caption.textContent = thumbnail ? thumbnail.alt : '';
        counter.textContent = (index + 1) + ' / ' + links.length;
    }
    function openImage(i) {
        lastFocus = document.activeElement;
        showImage(i);
        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        close.focus();
    }
    function closeImage() {
        lightbox.classList.remove('active');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
    }
    links.forEach((link, i) => link.addEventListener('click', function (event) {
        event.preventDefault();
        openImage(i);
    }));
    prev.addEventListener('click', () => showImage(index - 1));
    next.addEventListener('click', () => showImage(index + 1));
    close.addEventListener('click', closeImage);
    lightbox.addEventListener('click', event => {
        if (event.target === lightbox) closeImage();
    });
    document.addEventListener('keydown', event => {
        if (!lightbox.classList.contains('active')) return;
        if (event.key === 'ArrowLeft') showImage(index - 1);
        if (event.key === 'ArrowRight') showImage(index + 1);
        if (event.key === 'Escape') closeImage();
    });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>

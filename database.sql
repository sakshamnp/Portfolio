CREATE DATABASE IF NOT EXISTS saksham_portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE saksham_portfolio;

CREATE TABLE IF NOT EXISTS personal_details (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(150) NOT NULL,
 title VARCHAR(200) NOT NULL,
 country VARCHAR(100) NOT NULL DEFAULT 'Nepal',
 status VARCHAR(100) NOT NULL DEFAULT 'Undergraduate student',
 university VARCHAR(180) NOT NULL,
 degree VARCHAR(180) NOT NULL,
 expected_graduation_year SMALLINT UNSIGNED NULL,
 biography TEXT NOT NULL,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS education (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 institution VARCHAR(200) NOT NULL,
 qualification VARCHAR(200) NOT NULL,
 start_year SMALLINT UNSIGNED NULL,
 end_year SMALLINT UNSIGNED NULL,
 is_expected TINYINT(1) NOT NULL DEFAULT 0,
 period_label VARCHAR(80) NOT NULL,
 location VARCHAR(200) NOT NULL,
 logo_url VARCHAR(500) NOT NULL DEFAULT '',
 description TEXT NOT NULL,
 sort_order SMALLINT NOT NULL DEFAULT 0,
 INDEX idx_education_sort(sort_order,start_year)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS skills (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 category VARCHAR(100) NOT NULL,
 icon_class VARCHAR(200) NOT NULL DEFAULT '',
 icon_text VARCHAR(20) NOT NULL DEFAULT '',
 description VARCHAR(255) NOT NULL DEFAULT '',
 proficiency_label VARCHAR(80) NULL,
 sort_order SMALLINT NOT NULL DEFAULT 0,
 INDEX idx_skills_category(category,sort_order)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projects (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(180) NOT NULL,
 category VARCHAR(120) NOT NULL,
 context_label VARCHAR(120) NOT NULL DEFAULT 'Student project',
 short_description VARCHAR(500) NOT NULL,
 description TEXT NOT NULL,
 purpose TEXT NULL,
 learning_notes TEXT NULL,
 website_url VARCHAR(1000) NULL,
 repository_url VARCHAR(1000) NULL,
 screenshot_path VARCHAR(500) NULL,
 visual_class VARCHAR(100) NOT NULL DEFAULT 'visual-default',
 monogram VARCHAR(12) NOT NULL DEFAULT 'PR',
 technology_tags VARCHAR(500) NOT NULL DEFAULT '',
 is_published TINYINT(1) NOT NULL DEFAULT 0,
 sort_order SMALLINT NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX idx_projects_published(is_published,sort_order)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS social_links (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 platform VARCHAR(80) NOT NULL,
 url VARCHAR(1000) NOT NULL,
 icon_identifier VARCHAR(100) NOT NULL DEFAULT '',
 icon_text VARCHAR(20) NOT NULL DEFAULT '↗',
 display_order SMALLINT NOT NULL DEFAULT 0,
 is_visible TINYINT(1) NOT NULL DEFAULT 1,
 INDEX idx_social_order(is_visible,display_order)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact_messages (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(254) NOT NULL,
 subject VARCHAR(150) NOT NULL,
 message TEXT NOT NULL,
 ip_hash CHAR(64) NULL,
 is_read TINYINT(1) NOT NULL DEFAULT 0,
 submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 INDEX idx_contact_submitted(submitted_at),
 INDEX idx_contact_read(is_read,submitted_at)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS achievements (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 title VARCHAR(200) NOT NULL,
 description TEXT NOT NULL,
 achievement_date DATE NULL,
 certificate_url VARCHAR(1000) NULL,
 is_published TINYINT(1) NOT NULL DEFAULT 1,
 sort_order SMALLINT NOT NULL DEFAULT 0,
 INDEX idx_achievements_order(is_published,sort_order,achievement_date)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS site_settings (
 setting_key VARCHAR(100) PRIMARY KEY,
 setting_value TEXT NOT NULL,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO personal_details (id,full_name,title,country,status,university,degree,expected_graduation_year,biography) VALUES
(1,'Saksham Bhandari','Computer Engineering Student | Aspiring Software Developer','Nepal','Undergraduate student','Kathmandu University','Bachelor in Computer Engineering',2030,'I am a Computer Engineering student who enjoys exploring technology and developing practical software projects. My interests include programming, web development, and creating digital solutions that address real-world needs. Through academic projects and independent learning, I am continuously developing my technical skills and expanding my understanding of software development.')
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name), title=VALUES(title), biography=VALUES(biography);

INSERT INTO education (institution,qualification,start_year,end_year,is_expected,period_label,location,logo_url,description,sort_order) VALUES
('Horizon Gautam Buddha Secondary School','Nursery through Grade 12',2012,2026,0,'2012–2026','Tilottama, Rupandehi, Nepal','https://nepalisearchengine.com/storage/files/np/943/5f910c0ffd0f352046b6a4aeb98304c9.jpg','Completed my school education from Nursery through Grade 12 at Horizon Gautam Buddha Secondary School, building my academic foundation and developing my interests in technology and programming.',1),
('Kathmandu University','Bachelor in Computer Engineering',2026,2030,1,'2026–2030 (expected)','Dhulikhel, Kavrepalanchok, Nepal','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvCrVrRMJs351n5v3VEowO02mY7m7SUblM9Xt_t7p-mg&s','Pursuing a Bachelor in Computer Engineering at Kathmandu University, developing knowledge of programming, computer systems, engineering principles, and software development.',2);

INSERT INTO skills (name,category,icon_class,icon_text,description,sort_order) VALUES
('C','Programming','devicon-c-plain colored','C','Programming fundamentals',1),
('Python','Programming','devicon-python-plain colored','Py','Learning and scripting',2),
('JavaScript','Programming','devicon-javascript-plain colored','JS','Browser interactions',3),
('PHP','Programming','devicon-php-plain colored','PHP','Server-side web development',4),
('HTML5','Web Development','devicon-html5-plain colored','HTML','Semantic page structure',1),
('CSS3','Web Development','devicon-css3-plain colored','CSS','Responsive styling',2),
('Basic backend development','Web Development','','⌘','Learning server-side patterns',5),
('Database integration','Web Development','','▤','Connecting apps to databases',6),
('Git','Development Tools','devicon-git-plain colored','Git','Version control',1),
('GitHub','Development Tools','devicon-github-original','GH','Repositories and collaboration',2),
('Visual Studio Code','Development Tools','devicon-vscode-plain colored','VS','Code editor',3),
('MySQL','Development Tools','devicon-mysql-plain colored','SQL','Relational database basics',4),
('XAMPP','Development Tools','','X','Local PHP development environment',5),
('Microsoft Word','Microsoft Office','','W','Documents and reports',1),
('Microsoft Excel','Microsoft Office','','X','Spreadsheets',2),
('Microsoft PowerPoint','Microsoft Office','','P','Presentations',3)
;

INSERT INTO projects (title,category,context_label,short_description,description,purpose,learning_notes,website_url,repository_url,screenshot_path,visual_class,monogram,technology_tags,is_published,sort_order) VALUES
('HORIZ.ONE','School Website / Educational Platform','Grade 12 Practical 1','A school-focused digital platform developed as an academic project to bring educational information and school-related services together in one place.','HORIZ.ONE is a school-focused digital platform developed as an academic project. This portfolio entry describes the project at a high level; document individual features according to what is present in the deployed version.','Explore how a school website can centralize information and student-facing services in one place.','Building the project provides practice with web structure, interface design, and connecting front-end pages to backend data.','https://horizone-project.gt.tc/','','','visual-horizone','H.','HTML, CSS, JavaScript, PHP, MySQL',1,1),
('Tilottama Connect','Municipality Website / Civic Technology','Grade 12 Practical 2','A student project concept designed to make municipal information and civic services easier to access through a centralized digital platform.','Tilottama Connect is a student project concept, not an official municipal or government website. Potential ideas include municipal notices, citizen feedback, environmental information, waste-management updates, weather information, emergency contacts, maps, and FAQs. Only mark individual features as implemented after verifying them in the actual project.','Explore ways digital tools might make civic information easier to find and use.','The concept encourages thinking about information architecture, public-service usability, and responsible civic technology.','','','','visual-connect','TC','HTML, CSS, JavaScript, PHP, MySQL',1,2)
ON DUPLICATE KEY UPDATE short_description=VALUES(short_description);

INSERT INTO social_links (platform,url,icon_identifier,icon_text,display_order,is_visible) VALUES
('GitHub','https://github.com/sakshamnp','github','GH',1,1),
('LinkedIn','https://www.linkedin.com/in/sakshambhandarinp/','linkedin','in',2,1),
('Facebook','https://www.facebook.com/sakshambhandari.np','facebook','f',3,1),
('Instagram','https://www.instagram.com/_saksham.np/','instagram','◎',4,1),
('X','https://x.com/Saksham83826044','x','𝕏',5,1),
('Email','mailto:sakshambhandari.np@gmail.com','email','✉',6,1);

INSERT INTO site_settings (setting_key,setting_value) VALUES
('tilottama_connect_url',''),
('tilottama_connect_repository_url','')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value);

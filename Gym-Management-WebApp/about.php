<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_login();

$page_title = "About Project";

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="about-section">

    <div class="about-hero">
        <p class="small-label">Database Systems Project - CS160</p>
        <h2>Gym <span>Management</span> System</h2>
        <p>
            A professional database-driven web application designed for managing gym operations
            through an organized database, SQL implementation, and web-based CRUD interface.
        </p>
    </div>

    <div class="about-card">
        <h2>Project Title</h2>
        <p>
            <strong>Gym Management System with Web-Based CRUD Application</strong>
        </p>
    </div>

    <div class="about-card">
        <h2>Project Description</h2>

        <p>
            This Gym Management System is developed as part of the
            <strong>CS160 Database Systems Project-Based Learning</strong> task. The system is designed
            to manage real gym operations including members, trainers, membership plans, subscriptions,
            payments, attendance, workout plans, diet plans, equipment records, feedback, and SQL-based reports.
        </p>

        <p>
            The project follows proper database design concepts such as EERD, relational schema,
            primary keys, foreign keys, constraints, referential integrity, SQL views, triggers,
            joins, aggregation queries, and nested queries. The web interface allows the administrator
            to view, add, edit, and delete records in a user-friendly and professional manner.
        </p>

        <p>
            This application is built as a realistic gym management solution and can be further enhanced
            for real industrial use by adding online payments, member mobile app support, trainer scheduling,
            and automated attendance through QR or biometric systems.
        </p>
    </div>

    <div class="about-card">
        <h2>Project Objectives</h2>

        <div class="feature-list">
            <div>Design a complete relational database system</div>
            <div>Implement SQL constraints, keys, and relationships</div>
            <div>Create SQL views, triggers, and advanced queries</div>
            <div>Develop a professional web-based CRUD interface</div>
            <div>Manage members, trainers, subscriptions, and payments</div>
            <div>Generate useful reports using database views</div>
            <div>Apply database concepts in a real-world scenario</div>
            <div>Prepare a GitHub-ready project structure</div>
        </div>
    </div>

    <div class="about-card">
        <h2>Core System Modules</h2>

        <div class="feature-list">
            <div>Member Management</div>
            <div>Trainer Management</div>
            <div>Membership Plans</div>
            <div>Subscriptions</div>
            <div>Payments</div>
            <div>Attendance Records</div>
            <div>Workout & Diet Plans</div>
            <div>Equipment Tracking</div>
            <div>Feedback Management</div>
            <div>SQL Reports / Views</div>
        </div>
    </div>

    <div class="about-card">
        <h2>Team Members</h2>

        <div class="table-wrap about-table">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Student ID</th>
                </tr>

                <tr>
                    <td>Muhammad Abdullah Bin Aamer</td>
                    <td><span class="badge">Team Lead</span></td>
                    <td>F25605346</td>
                </tr>

                <tr>
                    <td>Muhammad Kabeer Atif</td>
                    <td><span class="badge">Team Member</span></td>
                    <td>F25605350</td>
                </tr>

                <tr>
                    <td>Talha Akhter</td>
                    <td><span class="badge">Team Member</span></td>
                    <td>F25605349</td>
                </tr>

                <tr>
                    <td>Haseeb Ullah</td>
                    <td><span class="badge">Team Member</span></td>
                    <td>F25605327</td>
                </tr>

                <tr>
                    <td>Hameed Ullah</td>
                    <td><span class="badge">Team Member</span></td>
                    <td>F25605307</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="about-card">
        <h2>Academic Information</h2>

        <div class="info-grid">
            <div><strong>Course</strong><span>CS160 Database Systems</span></div>
            <div><strong>Department</strong><span>BS Computer Science</span></div>
            <div><strong>Institute</strong><span>National University of Technology (NUTECH)</span></div>
            <div><strong>Project Type</strong><span>Project-Based Learning (PBL)</span></div>
            <div><strong>Technology Stack</strong><span>PHP, MySQL, HTML, CSS, XAMPP, SQL Server</span></div>
            <div><strong>Supervision</strong><span>Ms. Saima Yasmeen</span></div>
        </div>
    </div>

    <div class="about-card">
        <h2>Technologies Used</h2>

        <div class="tech-stack">
            <span>HTML5</span>
            <span>CSS3</span>
            <span>PHP</span>
            <span>MySQL</span>
            <span>XAMPP</span>
            <span>SQL Server</span>
            <span>SSMS</span>
            <span>GitHub</span>
        </div>
    </div>

    <div class="about-card">
        <h2>GitHub Repository Note</h2>

        <p>
            This project can be uploaded to GitHub with a clean repository structure including database
            scripts, web application files, EERD diagram, screenshots, report, and README documentation.
            The repository should clearly show the database implementation, frontend interface, CRUD features,
            views, triggers, and project documentation.
        </p>
    </div>

    <div class="about-card contact-card">
        <h2>Contact</h2>
        <p>
            For project-related queries, contact:
            <strong>abdullahaamer56@gmail.com</strong>
        </p>
    </div>

</div>

<?php require_once "includes/footer.php"; ?>

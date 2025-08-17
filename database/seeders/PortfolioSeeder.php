<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portfolio::create([
            'title' => 'E-Commerce Platform Development',
            'slug' => 'e-commerce-platform-development',
            'description' => 'Comprehensive e-commerce solution with advanced features including payment gateway integration, inventory management, and analytics dashboard.',
            'content' => '<p>This project involved developing a complete e-commerce platform from scratch using modern web technologies. The platform includes features such as product catalog management, shopping cart functionality, secure payment processing, order tracking, and comprehensive admin dashboard.</p><p>Key challenges overcome included implementing real-time inventory updates, optimizing performance for high traffic loads, and ensuring secure payment processing compliance with PCI DSS standards.</p>',
            'client_name' => 'TechMart Solutions',
            'project_url' => 'https://demo-ecommerce.example.com',
            'github_url' => 'https://github.com/torkata-tech/ecommerce-platform',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'Stripe API', 'Docker'],
            'project_date' => '2024-03-15',
            'status' => 'published',
            'order' => 1,
            'user_id' => 1,
            'meta_title' => 'E-Commerce Platform Development - Torkata Tech Portfolio',
            'meta_description' => 'Comprehensive e-commerce solution with advanced features including payment gateway integration and inventory management.',
            'meta_keywords' => 'e-commerce, laravel, vue.js, online store, payment gateway'
        ]);

        Portfolio::create([
            'title' => 'Corporate Website with CMS',
            'slug' => 'corporate-website-with-cms',
            'description' => 'Modern corporate website with custom content management system, SEO optimization, and responsive design.',
            'content' => '<p>Developed a professional corporate website featuring a custom-built content management system that allows non-technical staff to easily update content, manage news articles, and handle contact inquiries.</p><p>The website includes advanced SEO features, mobile-responsive design, and integration with social media platforms.</p>',
            'client_name' => 'Innovate Corp',
            'project_url' => 'https://innovatecorp.example.com',
            'github_url' => 'https://github.com/torkata-tech/corporate-cms',
            'technologies' => ['Laravel', 'Bootstrap', 'MySQL', 'jQuery', 'SEO Tools'],
            'project_date' => '2024-01-20',
            'status' => 'published',
            'order' => 2,
            'user_id' => 1,
            'meta_title' => 'Corporate Website with CMS - Torkata Tech Portfolio',
            'meta_description' => 'Modern corporate website with custom content management system and SEO optimization.',
            'meta_keywords' => 'corporate website, cms, seo, responsive design, laravel'
        ]);

        Portfolio::create([
            'title' => 'Mobile Task Management App',
            'slug' => 'mobile-task-management-app',
            'description' => 'Cross-platform mobile application for team task management with real-time collaboration features.',
            'content' => '<p>Built a comprehensive task management application that allows teams to collaborate effectively with features like real-time notifications, file sharing, progress tracking, and deadline management.</p><p>The app includes offline capability, data synchronization, and integration with popular productivity tools.</p>',
            'client_name' => 'ProductivityPlus Inc',
            'project_url' => 'https://apps.productivityplus.com',
            'github_url' => 'https://github.com/torkata-tech/task-manager-app',
            'technologies' => ['React Native', 'Node.js', 'MongoDB', 'Socket.io', 'Firebase'],
            'project_date' => '2023-11-10',
            'status' => 'published',
            'order' => 3,
            'user_id' => 1,
            'meta_title' => 'Mobile Task Management App - Torkata Tech Portfolio',
            'meta_description' => 'Cross-platform mobile application for team task management with real-time collaboration.',
            'meta_keywords' => 'mobile app, task management, react native, collaboration, productivity'
        ]);

        Portfolio::create([
            'title' => 'API Integration Dashboard',
            'slug' => 'api-integration-dashboard',
            'description' => 'Comprehensive dashboard for monitoring and managing multiple API integrations with analytics and reporting.',
            'content' => '<p>Developed a centralized dashboard solution that monitors multiple API endpoints, tracks performance metrics, manages authentication tokens, and provides detailed analytics on API usage patterns.</p><p>Features include automated health checks, alert systems, rate limiting monitoring, and comprehensive reporting tools.</p>',
            'client_name' => 'DataFlow Systems',
            'project_url' => 'https://dashboard.dataflow.example.com',
            'github_url' => 'https://github.com/torkata-tech/api-dashboard',
            'technologies' => ['Laravel', 'Chart.js', 'PostgreSQL', 'Redis', 'Docker', 'Swagger'],
            'project_date' => '2024-05-08',
            'status' => 'published',
            'order' => 4,
            'user_id' => 1,
            'meta_title' => 'API Integration Dashboard - Torkata Tech Portfolio',
            'meta_description' => 'Comprehensive dashboard for monitoring and managing multiple API integrations with analytics.',
            'meta_keywords' => 'api dashboard, monitoring, analytics, laravel, integration'
        ]);

        Portfolio::create([
            'title' => 'School Management System',
            'slug' => 'school-management-system',
            'description' => 'Complete school management solution with student records, grade tracking, and parent portal.',
            'content' => '<p>Comprehensive school management system that handles student enrollment, grade tracking, attendance monitoring, and communication between teachers, students, and parents.</p><p>The system includes features for scheduling, report generation, fee management, and mobile-responsive parent and student portals.</p>',
            'client_name' => 'EduTech Academy',
            'project_url' => 'https://portal.edutech.example.com',
            'github_url' => 'https://github.com/torkata-tech/school-management',
            'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Bootstrap', 'PDF Generator'],
            'project_date' => '2023-09-22',
            'status' => 'published',
            'order' => 5,
            'user_id' => 1,
            'meta_title' => 'School Management System - Torkata Tech Portfolio',
            'meta_description' => 'Complete school management solution with student records and parent portal.',
            'meta_keywords' => 'school management, education, student portal, grade tracking, laravel'
        ]);
    }
}

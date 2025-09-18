# 🎓 EduTrack LMS - Learning Management System

A comprehensive web-based Learning Management System built with CodeIgniter 4 for educational institutions.

## 📋 Project Overview

**EduTrack LMS** is designed to facilitate online learning by providing tools for teachers and students to manage courses, assignments, assessments, and communication efficiently.

### ✨ Key Features

- 👥 **User Management** - Role-based access (Admin, Teacher, Student)
- 🏫 **Classroom Management** - Create and join classes with unique codes
- 📚 **Learning Materials** - Upload and share educational resources
- 📝 **Assessment System** - Create and manage quizzes and assignments
- 📊 **Dashboard & Analytics** - Visual insights and progress tracking
- 🔔 **Notification System** - Email and in-app notifications
- 🌍 **Multi-language Support** - English and Malay (expandable)
- 📱 **Responsive Design** - Works on desktop, tablet, and mobile

## 🛠️ Tech Stack

- **Backend**: CodeIgniter 4 (PHP 8.1+)
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5, Chart.js
- **Authentication**: CodeIgniter Shield
- **File Storage**: Local storage with cloud integration (Cloudinary)
- **Version Control**: Git + GitHub

## 📦 Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 8.0
- XAMPP/WAMP (for local development)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/fahmize/edutrack_lms.git
   cd edutrack_lms
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp env .env
   # Edit .env file with your database credentials
   ```

4. **Database setup**
   ```bash
   php spark migrate
   php spark db:seed DatabaseSeeder
   ```

5. **Start development server**
   ```bash
   php spark serve
   ```

6. **Open your browser**
   ```
   http://localhost:8080
   ```

## 🗂️ Project Structure

```
edutrack_lms/
├── app/
│   ├── Controllers/        # Application controllers
│   ├── Models/            # Database models
│   ├── Views/             # View templates
│   └── Config/            # Configuration files
├── public/
│   ├── assets/            # CSS, JS, images
│   └── uploads/           # File upload directory
├── writable/              # Cache, logs, sessions
└── docs/                  # Project documentation
```

## 🏗️ Development Workflow

This project follows a 12-week development cycle:

- **Weeks 1-2**: Environment setup and database design
- **Weeks 3-4**: User authentication and role management
- **Weeks 5-6**: Classroom management and file upload
- **Weeks 7-8**: Assessment system development
- **Weeks 9-10**: Dashboard and notification system
- **Weeks 11-12**: Advanced features and deployment

## 🤝 Contributing

This is an internship learning project. Contributions and suggestions are welcome!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 Documentation

- [Development Setup Guide](docs/setup.md)
- [Database Schema](docs/database.md)
- [API Documentation](docs/api.md)
- [Deployment Guide](docs/deployment.md)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👨‍💻 Author

**Fahmi** - *Full Stack Developer*  
- GitHub: [@fahmize](https://github.com/fahmize)

## 🙏 Acknowledgments

- CodeIgniter 4 framework
- Bootstrap 5 for responsive design
- Chart.js for data visualization
- All the amazing open-source contributors

---

**📚 Learning Project**: This LMS is built as part of an internship learning experience, focusing on modern web development practices and educational technology.

---

*Last updated: [Current Date]*
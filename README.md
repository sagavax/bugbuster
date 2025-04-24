# 🐞 BugBuster

A simple PHP-based bug tracking system for managing and labeling software issues.  
Supports CRUD operations, status management (e.g., fixed, deleted), and soft delete with timeline logging.

## 👤 Author

**Tomáš Mišura**  
GitHub: [@sagavax](https://github.com/sagavax)

## 📦 Repository

- SSH: `git@github.com:sagavax/bugbuster.git`  
- HTTPS: `https://github.com/sagavax/bugbuster`

## 🚀 Features

- Add, edit, delete (soft delete) bugs
- Label bugs via modal UI
- Track status: open / fixed / deleted
- Timeline & activity log for all changes
- Pagination & status filtering
- Clean HTML/CSS UI with Font Awesome icons

## 🛠 Requirements

- PHP 7.x+
- MySQL
- Web server (Apache / Nginx)

## ⚙️ Setup

1. **Clone the repository**

    git clone https://github.com/your-username/bug-tracker.git
   cd bug-tracker

2. **Configure database connection**

Copy the example file and add your local DB credentials:

cp dbconnect.example.php dbconnect.php

3. **Configure database connection**

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'your_database';


4. **Run locally**
Open index.php (or your main entry point) in your browser via local server.


## 🔒 Security Tips

* Never commit dbconnect.php – it should be in .gitignore
* Use mysqli_real_escape_string or prepared statements to avoid SQL injection
* Consider .env-based config loading for cleaner multi-environment support

## 🧪 Development

Feel free to fork or submit pull requests. Feedback and improvements welcome!

## 📄 License

MIT – use it, improve it, break it, fix it.

## 📌 Project Status

The project is currently **active and in production**. 

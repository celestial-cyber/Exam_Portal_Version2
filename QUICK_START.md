# 🚀 ENGINE Exam Portal - Quick Start Guide

## ⚡ 5-Minute Setup

### Step 1: Ensure MySQL is Running
```bash
# Windows (XAMPP)
Start Apache & MySQL from XAMPP Control Panel

# Or check MySQL service
mysql -u root -p
```

### Step 2: Run Setup
Open in browser:
```
http://localhost/Engine-Exam-Portal/setup.php
```

You should see:
```
✓ Connected to MySQL successfully!
✓ Database 'engine_db' created successfully
✓ engine_user table created
✓ exam_questions table created
✓ exam_results table created
✓ User 'admin' created
✓ User 'trainer' created
✓ User 'user' created
✓ Sample questions added (12 total)
🎉 Setup complete!
```

### Step 3: Login
Go to: `http://localhost/Engine-Exam-Portal/login.php`

**Use these credentials:**

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| Trainer | `trainer` | `trainer123` |
| Student | `user` | `user123` |

---

## 🎯 What Each User Can Do

### 👤 Student (username: user)
1. Click "Take Exam"
2. Select exam category (Aptitude, Verbal, Technical)
3. Click "Enter Fullscreen Exam"
4. Answer 10 random questions (20 min timer)
5. Submit exam
6. View results
7. Results saved to your history

### 👨‍🏫 Trainer (username: trainer)
1. View dashboard with statistics:
   - Total questions in system
   - Number of registered students
   - Total exams completed
2. Monitor student activity

### 👨‍💼 Admin (username: admin)
1. View admin dashboard
2. See all users
3. View platform statistics
4. Manage system health

---

## 📁 Project Files

```
index.php              ← Start here (home page)
login.php              ← Login page
setup.php              ← Run this to setup DB
db.php                 ← Database config

student_dashboard.php  ← Student home
take_exam.php          ← Exam selection
quiz.php               ← Quiz player
submit_results.php     ← Results page

admin_dashboard.php    ← Admin panel
trainer_dashboard.php  ← Trainer panel

nav.php                ← Navigation menu
logout.php             ← Sign out
check_db.php           ← Debug database

README.md              ← Full documentation
FIXES.md               ← What was fixed
QUICK_START.md         ← This file
```

---

## 🧪 Test Each Role

### Test Student Flow
```
1. Login with: user / user123
2. Click "Take Exam"
3. Select "Aptitude"
4. Click "Enter Fullscreen Exam"
5. Answer questions
6. Click "Submit Exam"
7. See results
8. Go back to "Take Exam"
9. Results should show in dashboard
```

### Test Trainer Flow
```
1. Login with: trainer / trainer123
2. View statistics
3. Logout
```

### Test Admin Flow
```
1. Login with: admin / admin123
2. View users (should see all 3 users)
3. View statistics
4. See system running normally
5. Logout
```

---

## 🔍 Troubleshooting

### "Connection failed" Error
**Solution**: Check MySQL is running
```bash
# Windows: Start MySQL from XAMPP Control Panel
# Linux: sudo service mysql start
# Mac: brew services start mysql
```

### "Database not found" After Setup
**Solution**: Re-run setup.php in browser

### "Login Loop" (keeps going back to login)
**Solution**: 
1. Clear browser cache (Ctrl+Shift+Delete)
2. Close and reopen browser
3. Try incognito mode

### "Exam not loading"
**Solution**:
1. Ensure questions were inserted (see setup output)
2. Check browser console (F12) for errors
3. Run setup.php again

### "Results not showing"
**Solution**:
1. Ensure you completed and submitted an exam
2. Check database: `SELECT * FROM exam_results;`
3. Refresh dashboard

---

## 🔧 Common Configurations

### Change MySQL Password
If your MySQL password is not `root@123`, edit `db.php`:
```php
$db_password = "YOUR_PASSWORD";  // Change this
```

### Add More Questions
Option 1: Run `setup.php` again (adds more examples)

Option 2: Add via database:
```sql
INSERT INTO exam_questions 
(question_text, category, option_a, option_b, option_c, option_d, correct_answer) 
VALUES 
('What is 2+2?', 'aptitude', '3', '4', '5', '6', 'b');
```

### Create New Users
```sql
INSERT INTO engine_user (username, password, role) 
VALUES ('newuser', 'password123', 'user');
```

### Change Exam Duration
Edit `quiz.php`, find:
```javascript
let timeInSeconds = 20 * 60;  // Change 20 to your minutes
```

---

## ✅ Checklist After Setup

- [ ] Database created successfully
- [ ] 3 default users created
- [ ] Sample questions inserted
- [ ] Can login with each user
- [ ] Student can access dashboard
- [ ] Student can take exam
- [ ] Exam timer works (20 min)
- [ ] Results save correctly
- [ ] Admin dashboard shows statistics
- [ ] Trainer dashboard shows statistics
- [ ] Logout works properly
- [ ] Cannot access dashboard without login

---

## 🔐 Security Features

✅ **Secure by Default**
- SQL Injection Protected (Prepared Statements)
- XSS Protected (Output Escaping)
- Session Validation (Role-based access)
- Secure Exams (Fullscreen + Anti-cheat)

✅ **Already Implemented:**
- Password verification (plaintext for demo)
- Session management
- Role-based dashboards
- Secure database queries
- Error handling

---

## 📊 Database Check

To view table contents:
```sql
-- Check users
SELECT * FROM engine_user;

-- Check questions
SELECT COUNT(*) FROM exam_questions;
SELECT DISTINCT category FROM exam_questions;

-- Check results
SELECT * FROM exam_results;
```

Or use phpMyAdmin:
```
http://localhost/phpmyadmin
Username: root
Password: root@123
Database: engine_db
```

---

## 🎓 Sample Exam Flow

1. **Login** → Dashboard
2. **Take Exam** → Select "Aptitude"
3. **Exam Start** → Fullscreen mode
4. **Answer Questions** → 10 questions, random order
5. **Timer Running** → 20 minutes countdown
6. **Submit** → Automatic or click button
7. **Results** → Score shown immediately
8. **Save** → Result stored in database
9. **Dashboard** → Result added to history

---

## 🆘 Support

### Check Logs
1. Browser Console: F12 → Console tab
2. MySQL Error: Check MySQL logs
3. PHP Error: Check Apache error log

### Common Fixes
```bash
# Clear cache
Ctrl+Shift+Delete

# Test database connection
Check "Check DB" → check_db.php

# Verify PHP
<?php phpinfo(); ?>

# Reload everything
Close browser → Clear cache → Restart server
```

---

## 📞 Quick Links

| Page | URL |
|------|-----|
| Home | `/index.php` |
| Login | `/login.php` |
| Setup | `/setup.php` |
| Check DB | `/check_db.php` |
| Admin Dashboard | `/admin_dashboard.php` |
| Trainer Dashboard | `/trainer_dashboard.php` |
| Student Dashboard | `/student_dashboard.php` |

---

## 🎉 You're Ready!

**Everything is set up and working!**

1. Go to: `http://localhost/Engine-Exam-Portal/`
2. Login with your role (admin/trainer/user)
3. Start using the system!

---

**Last Updated**: February 2026
**Status**: ✅ Fully Functional
**Version**: 1.0 Complete

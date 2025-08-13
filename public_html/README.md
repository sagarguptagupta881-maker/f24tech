# F24Tech Professional Website - PHP Backend Version

A complete, modern PHP website for F24Tech Softwares with professional design, contact forms, analytics, database integration, and a full admin panel.

## 🚀 Features

### ✅ **Complete Website Structure**
- **Professional Design** - Modern, responsive layout with Tailwind CSS
- **Multi-page Navigation** - Home, About, Services, Portfolio, Contact, Blog, Careers
- **Mobile Responsive** - Optimized for all devices and screen sizes
- **SEO Optimized** - Clean URLs, meta tags, and semantic HTML

### 📊 **Admin Panel Features**
- **Secure Login System** - Admin authentication with session management
- **Project Management** - Add, edit, delete, and manage portfolio projects
- **Contact Management** - View and manage contact form submissions
- **Analytics Dashboard** - Track website performance and user behavior
- **Settings Panel** - Configure admin preferences and view system info

### 🔧 **Backend Functionality**
- **PHP Backend** - Server-side processing and routing
- **MySQL Database** - Contact forms, projects, and analytics storage
- **Database Management** - Complete CRUD operations for all data
- **Form Processing** - Working contact forms with database storage
- **Newsletter System** - Email subscription management

### 🎨 **Professional Design**
- **Modern UI/UX** - Clean, professional interface design
- **Smooth Animations** - CSS transitions and hover effects
- **Interactive Elements** - Mobile menu, smooth scrolling, form validation
- **Professional Typography** - Inter font family for modern look
- **Color Scheme** - Blue and green gradient theme

## 📁 **File Structure**

```
/
├── index.php                 # Main entry point with routing
├── admin/                    # Admin panel
│   ├── index.php            # Admin dashboard
│   ├── login.php            # Admin login
│   ├── logout.php           # Admin logout
│   ├── add-project.php      # Add new project
│   ├── edit-project.php     # Edit existing project
│   ├── manage-portfolio.php # Manage all projects
│   ├── manage-contacts.php  # Manage contact submissions
│   ├── analytics.php        # Analytics dashboard
│   └── settings.php         # Admin settings
├── includes/
│   ├── header.php           # Site header with navigation
│   ├── footer.php           # Site footer with links
│   ├── admin-header.php     # Admin panel header
│   ├── admin-footer.php     # Admin panel footer
│   └── cookie-consent.php   # GDPR cookie consent banner
├── pages/
│   ├── home.php             # Homepage content
│   ├── about.php            # About page
│   ├── services.php         # Services listing
│   ├── portfolio.php        # Portfolio showcase
│   ├── contact.php          # Contact form page
│   ├── blog.php             # Blog listing
│   ├── careers.php          # Careers page
│   ├── privacy.php          # Privacy policy
│   └── terms.php            # Terms of service
├── components/
│   ├── about-section.php    # About section component
│   ├── services-section.php # Services section component
│   ├── portfolio-section.php # Portfolio section component
│   └── contact-section.php  # Contact section component
├── api/
│   ├── contact.php          # Contact form handler
│   ├── newsletter.php       # Newsletter subscription handler
│   └── analytics.php        # Analytics tracking API
├── assets/
│   ├── css/
│   │   └── style.css        # Custom styles and animations
│   └── js/
│       ├── main.js          # Main JavaScript functionality
│       └── analytics.js     # Analytics tracking system
└── config/
    └── database.php         # Database configuration and helpers
```

## 🛠️ **Installation & Setup**

### **1. Upload Files**
Upload all files to your web server's document root or subdirectory.

### **2. Database Configuration**
The website is pre-configured to use your existing MySQL database:
- **Host:** localhost
- **Database:** u925328211_ncb
- **Username:** u925328211_ncb
- **Password:** Aman123@f24tech24

### **3. Database Tables**
The database tables will be created automatically when you first access the website. The following tables will be created:

- `projects` - Portfolio projects
- `project_features` - Project features
- `project_technologies` - Technologies used in projects
- `project_tags` - Project tags
- `project_results` - Project results/achievements
- `project_testimonials` - Client testimonials
- `contact_submissions` - Contact form submissions
- `newsletter_subscriptions` - Newsletter subscriptions
- `page_views` - Page analytics

### **4. Admin Access**
- **URL:** `your-domain.com/admin/`
- **Username:** admin
- **Password:** admin123

**⚠️ Important:** Change the default admin password after first login!

## 🔑 **Admin Panel Features**

### **Dashboard**
- Overview of key metrics (projects, contacts, subscribers, page views)
- Recent activity feed
- Quick action buttons
- System status information

### **Project Management**
- **Add Projects:** Complete project creation with all details
- **Edit Projects:** Update existing project information
- **Manage Portfolio:** View, filter, and organize all projects
- **Status Control:** Draft, Published, Archived status management

### **Contact Management**
- View all contact form submissions
- Update lead status (New, Contacted, Qualified, Closed)
- Search and filter contacts
- Direct email integration

### **Analytics**
- Page view tracking
- Visitor statistics
- Device breakdown
- Contact form analytics
- Date range filtering

### **Settings**
- Change admin password
- View system information
- Database status
- Quick access to all admin functions

## 📊 **Database Schema**

### **Projects System:**
- `projects` - Main project information
- `project_features` - List of project features
- `project_technologies` - Technologies used
- `project_tags` - Project categorization tags
- `project_results` - Achievement metrics
- `project_testimonials` - Client feedback

### **Contact System:**
- `contact_submissions` - All contact form data
- `newsletter_subscriptions` - Email subscriptions

### **Analytics:**
- `page_views` - Page tracking data

## 🎯 **Key Features**

### **Frontend Features:**
- ✅ **Responsive Design** - Works on all devices
- ✅ **Professional Content** - Complete website copy
- ✅ **Contact Forms** - Working forms with database storage
- ✅ **Newsletter Signup** - Email collection system
- ✅ **Mobile Navigation** - Touch-friendly mobile menu
- ✅ **Smooth Scrolling** - Enhanced user experience
- ✅ **SEO Optimized** - Search engine friendly

### **Backend Features:**
- ✅ **Admin Authentication** - Secure login system
- ✅ **Project CRUD** - Complete project management
- ✅ **Contact Management** - Lead tracking and management
- ✅ **Analytics Tracking** - Website performance monitoring
- ✅ **Database Integration** - Full MySQL integration
- ✅ **Form Processing** - Server-side form handling

## 🔒 **Security Features**

- **Session Management** - Secure admin sessions
- **Input Validation** - Server-side form validation
- **SQL Injection Protection** - Parameterized queries
- **XSS Protection** - Output escaping
- **CSRF Protection** - Form token validation (recommended for production)

## 📞 **Contact Information**

The website includes complete contact information:
- **Email:** sales@f24tech.com
- **Phone:** +1 (555) 123-4567
- **Address:** 123 Tech Street, Silicon Valley, CA 94000
- **Hours:** Mon-Fri 8am-5pm PST

## 🎨 **Customization**

### **Content Updates:**
- **Contact Info:** Update in `includes/footer.php` and `pages/contact.php`
- **Company Info:** Update in various page files
- **Services:** Edit `pages/services.php` and `components/services-section.php`
- **About Content:** Update `pages/about.php` and `components/about-section.php`

### **Design Changes:**
- **Colors:** Update CSS variables in `assets/css/style.css`
- **Fonts:** Change font imports in HTML head sections
- **Layout:** Modify Tailwind classes in PHP files

### **Admin Customization:**
- **Password:** Change in admin settings or directly in code
- **Admin User:** Update authentication logic in `admin/login.php`
- **Permissions:** Add role-based access control as needed

## 🚀 **Production Deployment**

### **Security Checklist:**
- [ ] Change default admin password
- [ ] Update database credentials if needed
- [ ] Enable HTTPS
- [ ] Set up regular database backups
- [ ] Configure error logging
- [ ] Set appropriate file permissions

### **Performance Optimization:**
- [ ] Enable PHP OPcache
- [ ] Configure database indexing
- [ ] Set up CDN for static assets
- [ ] Enable gzip compression
- [ ] Optimize images

## 📈 **Analytics & Tracking**

The website includes a basic analytics system that tracks:
- Page views and unique visitors
- Popular pages and time spent
- Contact form submissions
- Newsletter subscriptions
- Basic device/browser information

## 🆘 **Troubleshooting**

### **Common Issues:**
1. **Database Connection:** Check credentials in `config/database.php`
2. **Admin Login:** Default is admin/admin123
3. **File Permissions:** Ensure PHP can read/write files
4. **Missing Tables:** Tables are created automatically on first access

### **Support:**
For technical support or customization requests:
- **Email:** admin@f24tech.com
- **Documentation:** This README file

---

**🎉 Your complete PHP-powered F24Tech website with admin panel is now ready!**

Access the admin panel at `/admin/` and start managing your content with full database integration and professional features.
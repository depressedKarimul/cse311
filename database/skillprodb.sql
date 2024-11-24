CREATE DATABASE skillProDB;

-- User Table
CREATE TABLE User (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  firstName VARCHAR(50),
  lastName VARCHAR(50),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role ENUM('student', 'instructor', 'admin'),
  profile_pic VARCHAR(255),
  bio TEXT
);
-- Instructor Table
CREATE TABLE Instructor (
  instructor_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  expertise VARCHAR(255),
  total_courses INT DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES User(user_id)
);
-- Student Table
CREATE TABLE Student (
  student_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  total_courses_enrolled INT DEFAULT 0,
  progress DECIMAL(5, 2) DEFAULT 0.0,
  FOREIGN KEY (user_id) REFERENCES User(user_id)
);
-- Course Table
CREATE TABLE Course (
  course_id INT AUTO_INCREMENT PRIMARY KEY,
  instructor_id INT,
  title VARCHAR(255),
  description TEXT,
  category VARCHAR(100),
  difficulty ENUM('beginner', 'intermediate', 'advanced'),
  price DECIMAL(10, 2),
  status ENUM('active', 'inactive'),
  FOREIGN KEY (instructor_id) REFERENCES Instructor(instructor_id)
);
-- Course_Content Table
CREATE TABLE Course_Content (
  content_id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT,
  type ENUM('video', 'article', 'quiz'),
  title VARCHAR(255),
  file_url VARCHAR(255),
  content_duration TIME,
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Category Table
CREATE TABLE Category (
  category_id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) UNIQUE
);
-- Quiz Table
CREATE TABLE Quiz (
  quiz_id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT,
  total_questions INT,
  passing_marks INT,
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Question Table
CREATE TABLE Question (
  question_id INT AUTO_INCREMENT PRIMARY KEY,
  quiz_id INT,
  question_text TEXT,
  question_type ENUM('multiple_choice', 'true_false', 'short_answer'),
  answer TEXT,
  FOREIGN KEY (quiz_id) REFERENCES Quiz(quiz_id)
);
-- Certificate Table
CREATE TABLE Certificate (
  certificate_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  course_id INT,
  issue_date DATE,
  FOREIGN KEY (student_id) REFERENCES Student(student_id),
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Enrollment Table
CREATE TABLE Enrollment (
  enrollment_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  course_id INT,
  enrollment_date DATE,
  completion_date DATE,
  FOREIGN KEY (student_id) REFERENCES Student(student_id),
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Payment Table
CREATE TABLE Payment (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  course_id INT,
  amount DECIMAL(10, 2),
  payment_date DATE,
  transaction_id VARCHAR(255),
  FOREIGN KEY (student_id) REFERENCES Student(student_id),
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Review Table
CREATE TABLE Review (
  review_id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT,
  course_id INT,
  rating INT CHECK (
    rating BETWEEN 1 AND 5
  ),
  comment TEXT,
  review_date DATE,
  FOREIGN KEY (student_id) REFERENCES Student(student_id),
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Admin Table
CREATE TABLE Admin (
  admin_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  permissions_level ENUM('low', 'medium', 'high'),
  FOREIGN KEY (user_id) REFERENCES User(user_id)
);
-- Course_Approval Table
CREATE TABLE Course_Approval (
  approval_id INT AUTO_INCREMENT PRIMARY KEY,
  admin_id INT,
  course_id INT,
  approval_status ENUM('approved', 'rejected', 'pending'),
  approval_date DATE,
  FOREIGN KEY (admin_id) REFERENCES Admin(admin_id),
  FOREIGN KEY (course_id) REFERENCES Course(course_id)
);
-- Forum_Post Table
CREATE TABLE Forum_Post (
  post_id INT AUTO_INCREMENT PRIMARY KEY,
  course_id INT,
  user_id INT,
  post_text TEXT,
  post_date DATE,
  FOREIGN KEY (course_id) REFERENCES Course(course_id),
  FOREIGN KEY (user_id) REFERENCES User(user_id)
);










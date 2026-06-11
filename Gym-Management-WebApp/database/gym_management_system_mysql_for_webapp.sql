DROP DATABASE IF EXISTS gym_management_system;
CREATE DATABASE gym_management_system;
USE gym_management_system;

CREATE TABLE APP_USER (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_app_user_role CHECK (role IN ('admin', 'user'))
);

CREATE TABLE PERSON (
    person_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    street VARCHAR(100) NOT NULL,
    city VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    CONSTRAINT chk_person_gender CHECK (gender IN ('Male', 'Female', 'Other'))
);

CREATE TABLE PERSON_PHONE (
    phone_id INT AUTO_INCREMENT PRIMARY KEY,
    person_id INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    CONSTRAINT uq_person_phone UNIQUE (person_id, phone_number),
    CONSTRAINT fk_person_phone_person FOREIGN KEY (person_id)
    REFERENCES PERSON(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE MEMBER (
    person_id INT PRIMARY KEY,
    joining_date DATE NOT NULL,
    health_goal VARCHAR(50) NOT NULL,
    emergency_contact VARCHAR(20) NOT NULL,
    member_status VARCHAR(20) NOT NULL DEFAULT 'Active',
    CONSTRAINT chk_member_status CHECK (member_status IN ('Active', 'Inactive', 'Suspended')),
    CONSTRAINT chk_health_goal CHECK (health_goal IN ('Weight Loss', 'Muscle Gain', 'Fitness', 'Strength Training', 'Endurance')),
    CONSTRAINT fk_member_person FOREIGN KEY (person_id)
    REFERENCES PERSON(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE TRAINER (
    person_id INT PRIMARY KEY,
    specialization_area VARCHAR(60) NOT NULL,
    experience_years INT NOT NULL,
    salary DECIMAL(10,2) NOT NULL,
    trainer_status VARCHAR(20) NOT NULL DEFAULT 'Active',
    CONSTRAINT chk_experience_years CHECK (experience_years >= 0),
    CONSTRAINT chk_trainer_salary CHECK (salary > 0),
    CONSTRAINT chk_trainer_status CHECK (trainer_status IN ('Active', 'Inactive', 'On Leave')),
    CONSTRAINT fk_trainer_person FOREIGN KEY (person_id)
    REFERENCES PERSON(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE MEMBERSHIP_PLAN (
    plan_id INT AUTO_INCREMENT PRIMARY KEY,
    plan_name VARCHAR(60) NOT NULL UNIQUE,
    duration_months INT NOT NULL,
    monthly_fee DECIMAL(10,2) NOT NULL,
    plan_type VARCHAR(30) NOT NULL,
    description VARCHAR(255),
    CONSTRAINT chk_duration_months CHECK (duration_months > 0),
    CONSTRAINT chk_monthly_fee CHECK (monthly_fee > 0),
    CONSTRAINT chk_plan_type CHECK (plan_type IN ('Basic', 'Standard', 'Premium', 'Student', 'Personal Training'))
);

CREATE TABLE SUBSCRIPTION (
    subscription_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    plan_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    subscription_status VARCHAR(20) NOT NULL DEFAULT 'Pending',
    discount_percent DECIMAL(5,2) DEFAULT 0,
    CONSTRAINT chk_subscription_dates CHECK (end_date > start_date),
    CONSTRAINT chk_subscription_status CHECK (subscription_status IN ('Pending', 'Active', 'Expired', 'Cancelled')),
    CONSTRAINT chk_discount_percent CHECK (discount_percent >= 0 AND discount_percent <= 100),
    CONSTRAINT fk_subscription_member FOREIGN KEY (member_id)
    REFERENCES MEMBER(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_subscription_plan FOREIGN KEY (plan_id)
    REFERENCES MEMBERSHIP_PLAN(plan_id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

CREATE TABLE PAYMENT (
    subscription_id INT NOT NULL,
    payment_no INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    payment_method VARCHAR(30) NOT NULL,
    payment_status VARCHAR(20) NOT NULL,
    PRIMARY KEY (subscription_id, payment_no),
    CONSTRAINT chk_payment_no CHECK (payment_no > 0),
    CONSTRAINT chk_payment_amount CHECK (amount > 0),
    CONSTRAINT chk_payment_method CHECK (payment_method IN ('Cash', 'Card', 'JazzCash', 'EasyPaisa', 'Bank Transfer')),
    CONSTRAINT chk_payment_status CHECK (payment_status IN ('Paid', 'Pending', 'Failed', 'Refunded')),
    CONSTRAINT fk_payment_subscription FOREIGN KEY (subscription_id)
    REFERENCES SUBSCRIPTION(subscription_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE ATTENDANCE (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    check_in_date DATE NOT NULL,
    check_in_time TIME NOT NULL,
    check_out_time TIME,
    attendance_status VARCHAR(20) NOT NULL DEFAULT 'Present',
    CONSTRAINT chk_attendance_status CHECK (attendance_status IN ('Present', 'Late', 'Absent')),
    CONSTRAINT fk_attendance_member FOREIGN KEY (member_id)
    REFERENCES MEMBER(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE WORKOUT_PLAN (
    workout_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    trainer_id INT NULL,
    plan_title VARCHAR(100) NOT NULL,
    difficulty_level VARCHAR(20) NOT NULL,
    assigned_date DATE NOT NULL,
    notes VARCHAR(255),
    CONSTRAINT chk_difficulty_level CHECK (difficulty_level IN ('Beginner', 'Intermediate', 'Advanced')),
    CONSTRAINT fk_workout_member FOREIGN KEY (member_id)
    REFERENCES MEMBER(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_workout_trainer FOREIGN KEY (trainer_id)
    REFERENCES TRAINER(person_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE DIET_PLAN (
    diet_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    trainer_id INT NULL,
    goal VARCHAR(50) NOT NULL,
    daily_calories INT NOT NULL,
    meal_details VARCHAR(255) NOT NULL,
    assigned_date DATE NOT NULL,
    CONSTRAINT chk_diet_goal CHECK (goal IN ('Weight Loss', 'Muscle Gain', 'Fitness', 'Strength Training', 'Endurance')),
    CONSTRAINT chk_daily_calories CHECK (daily_calories BETWEEN 1000 AND 5000),
    CONSTRAINT fk_diet_member FOREIGN KEY (member_id)
    REFERENCES MEMBER(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_diet_trainer FOREIGN KEY (trainer_id)
    REFERENCES TRAINER(person_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

CREATE TABLE EQUIPMENT (
    equipment_id INT AUTO_INCREMENT PRIMARY KEY,
    equipment_name VARCHAR(80) NOT NULL UNIQUE,
    category VARCHAR(50) NOT NULL,
    quantity_available INT NOT NULL,
    condition_status VARCHAR(30) NOT NULL,
    last_maintenance_date DATE,
    CONSTRAINT chk_equipment_quantity CHECK (quantity_available >= 0),
    CONSTRAINT chk_condition_status CHECK (condition_status IN ('Good', 'Needs Maintenance', 'Damaged'))
);

CREATE TABLE WORKOUT_EQUIPMENT (
    workout_equipment_id INT AUTO_INCREMENT PRIMARY KEY,
    workout_id INT NOT NULL,
    equipment_id INT NOT NULL,
    sets_required INT NOT NULL,
    usage_notes VARCHAR(255),
    CONSTRAINT chk_sets_required CHECK (sets_required > 0),
    CONSTRAINT fk_workout_equipment_workout FOREIGN KEY (workout_id)
    REFERENCES WORKOUT_PLAN(workout_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_workout_equipment_equipment FOREIGN KEY (equipment_id)
    REFERENCES EQUIPMENT(equipment_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

CREATE TABLE FEEDBACK (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    member_id INT NOT NULL,
    trainer_id INT NULL,
    rating INT NOT NULL,
    comments VARCHAR(255),
    feedback_date DATE NOT NULL,
    CONSTRAINT chk_feedback_rating CHECK (rating BETWEEN 1 AND 5),
    CONSTRAINT fk_feedback_member FOREIGN KEY (member_id)
    REFERENCES MEMBER(person_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_feedback_trainer FOREIGN KEY (trainer_id)
    REFERENCES TRAINER(person_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
);

DELIMITER //

CREATE TRIGGER trg_activate_subscription_after_payment
AFTER INSERT ON PAYMENT
FOR EACH ROW
BEGIN
    IF NEW.payment_status = 'Paid' THEN
        UPDATE SUBSCRIPTION
        SET subscription_status = 'Active'
        WHERE subscription_id = NEW.subscription_id
        AND subscription_status = 'Pending';
    END IF;
END//

DELIMITER ;

INSERT INTO PERSON (person_id, first_name, last_name, date_of_birth, gender, street, city, email) VALUES
(1, 'Ali', 'Khan', '2003-04-12', 'Male', 'Satellite Town', 'Rawalpindi', 'ali.khan@gmail.com'),
(2, 'Hassan', 'Raza', '2002-08-21', 'Male', 'Chandni Chowk', 'Rawalpindi', 'hassan.raza@gmail.com'),
(3, 'Usman', 'Malik', '2001-02-18', 'Male', 'I-10 Markaz', 'Islamabad', 'usman.malik@gmail.com'),
(4, 'Ayesha', 'Noor', '2004-01-25', 'Female', 'Bahria Town', 'Rawalpindi', 'ayesha.noor@gmail.com'),
(5, 'Fatima', 'Zahra', '2003-11-09', 'Female', 'PWD Society', 'Islamabad', 'fatima.zahra@gmail.com'),
(6, 'Hamza', 'Saeed', '2000-06-14', 'Male', 'Saddar', 'Rawalpindi', 'hamza.saeed@gmail.com'),
(7, 'Zain', 'Ahmed', '2002-12-03', 'Male', 'Gulraiz', 'Rawalpindi', 'zain.ahmed@gmail.com'),
(8, 'Maryam', 'Iqbal', '2003-03-30', 'Female', 'G-11', 'Islamabad', 'maryam.iqbal@gmail.com'),
(9, 'Bilal', 'Akhtar', '2001-09-17', 'Male', 'Faizabad', 'Rawalpindi', 'bilal.akhtar@gmail.com'),
(10, 'Laiba', 'Shah', '2004-05-05', 'Female', 'DHA Phase 2', 'Islamabad', 'laiba.shah@gmail.com'),
(11, 'Danish', 'Mehmood', '1999-10-28', 'Male', 'Adyala Road', 'Rawalpindi', 'danish.mehmood@gmail.com'),
(12, 'Hira', 'Aslam', '2002-07-19', 'Female', 'E-11', 'Islamabad', 'hira.aslam@gmail.com'),
(13, 'Saad', 'Ali', '2000-01-11', 'Male', 'Commercial Market', 'Rawalpindi', 'saad.ali@gmail.com'),
(14, 'Nimra', 'Khalid', '2003-09-06', 'Female', 'I-8', 'Islamabad', 'nimra.khalid@gmail.com'),
(15, 'Taha', 'Qureshi', '2001-12-24', 'Male', 'Westridge', 'Rawalpindi', 'taha.qureshi@gmail.com'),
(16, 'Ahmed', 'Farooq', '1988-03-15', 'Male', 'Bahria Phase 7', 'Rawalpindi', 'ahmed.farooq@gympro.com'),
(17, 'Sara', 'Imran', '1990-07-11', 'Female', 'F-10', 'Islamabad', 'sara.imran@gympro.com'),
(18, 'Omar', 'Sheikh', '1985-09-22', 'Male', 'DHA Phase 1', 'Islamabad', 'omar.sheikh@gympro.com'),
(19, 'Nadia', 'Yousaf', '1992-02-03', 'Female', 'G-9', 'Islamabad', 'nadia.yousaf@gympro.com'),
(20, 'Fahad', 'Hussain', '1987-12-18', 'Male', 'Saddar', 'Rawalpindi', 'fahad.hussain@gympro.com'),
(21, 'Sana', 'Rashid', '1991-05-27', 'Female', 'Bahria Town', 'Rawalpindi', 'sana.rashid@gympro.com'),
(22, 'Kamran', 'Javed', '1984-08-09', 'Male', 'I-9', 'Islamabad', 'kamran.javed@gympro.com'),
(23, 'Mahnoor', 'Tariq', '1993-04-16', 'Female', 'PWD Society', 'Islamabad', 'mahnoor.tariq@gympro.com'),
(24, 'Rehan', 'Butt', '1989-06-29', 'Male', 'Chaklala', 'Rawalpindi', 'rehan.butt@gympro.com'),
(25, 'Iqra', 'Saleem', '1994-01-20', 'Female', 'Gulberg Greens', 'Islamabad', 'iqra.saleem@gympro.com'),
(26, 'Waqas', 'Nadeem', '1986-10-05', 'Male', 'G-13', 'Islamabad', 'waqas.nadeem@gympro.com'),
(27, 'Amina', 'Rauf', '1995-11-13', 'Female', 'Airport Housing Society', 'Rawalpindi', 'amina.rauf@gympro.com'),
(28, 'Shahzaib', 'Arif', '1983-07-01', 'Male', 'Murree Road', 'Rawalpindi', 'shahzaib.arif@gympro.com'),
(29, 'Rimsha', 'Khan', '1992-09-09', 'Female', 'I-14', 'Islamabad', 'rimsha.khan@gympro.com'),
(30, 'Talha', 'Naeem', '1988-12-31', 'Male', 'Askari 14', 'Rawalpindi', 'talha.naeem@gympro.com');

INSERT INTO PERSON_PHONE (person_id, phone_number) VALUES
(1, '03001234501'),
(2, '03001234502'),
(3, '03001234503'),
(4, '03001234504'),
(5, '03001234505'),
(6, '03001234506'),
(7, '03001234507'),
(8, '03001234508'),
(9, '03001234509'),
(10, '03001234510'),
(11, '03001234511'),
(12, '03001234512'),
(13, '03001234513'),
(14, '03001234514'),
(15, '03001234515'),
(16, '03111234516'),
(17, '03111234517'),
(18, '03111234518'),
(19, '03111234519'),
(20, '03111234520'),
(21, '03111234521'),
(22, '03111234522'),
(23, '03111234523'),
(24, '03111234524'),
(25, '03111234525'),
(26, '03111234526'),
(27, '03111234527'),
(28, '03111234528'),
(29, '03111234529'),
(30, '03111234530');

INSERT INTO MEMBER (person_id, joining_date, health_goal, emergency_contact, member_status) VALUES
(1, '2026-01-10', 'Weight Loss', '03210000001', 'Active'),
(2, '2026-01-12', 'Muscle Gain', '03210000002', 'Active'),
(3, '2026-01-15', 'Fitness', '03210000003', 'Active'),
(4, '2026-01-20', 'Endurance', '03210000004', 'Active'),
(5, '2026-02-01', 'Weight Loss', '03210000005', 'Active'),
(6, '2026-02-05', 'Strength Training', '03210000006', 'Active'),
(7, '2026-02-10', 'Muscle Gain', '03210000007', 'Active'),
(8, '2026-02-18', 'Fitness', '03210000008', 'Active'),
(9, '2026-03-01', 'Weight Loss', '03210000009', 'Active'),
(10, '2026-03-04', 'Endurance', '03210000010', 'Active'),
(11, '2026-03-10', 'Strength Training', '03210000011', 'Inactive'),
(12, '2026-03-15', 'Fitness', '03210000012', 'Active'),
(13, '2026-04-01', 'Muscle Gain', '03210000013', 'Active'),
(14, '2026-04-05', 'Weight Loss', '03210000014', 'Suspended'),
(15, '2026-04-10', 'Strength Training', '03210000015', 'Active');

INSERT INTO TRAINER (person_id, specialization_area, experience_years, salary, trainer_status) VALUES
(16, 'Strength Training', 8, 85000.00, 'Active'),
(17, 'Weight Loss Coaching', 6, 70000.00, 'Active'),
(18, 'Bodybuilding', 10, 95000.00, 'Active'),
(19, 'Yoga and Flexibility', 5, 65000.00, 'Active'),
(20, 'Cardio Fitness', 7, 72000.00, 'Active'),
(21, 'Nutrition Guidance', 4, 60000.00, 'Active'),
(22, 'Powerlifting', 12, 110000.00, 'Active'),
(23, 'Functional Training', 5, 68000.00, 'Active'),
(24, 'HIIT Training', 9, 88000.00, 'Active'),
(25, 'Female Fitness Coaching', 6, 75000.00, 'Active'),
(26, 'Rehabilitation Training', 11, 105000.00, 'On Leave'),
(27, 'Pilates', 3, 55000.00, 'Active'),
(28, 'Athletic Conditioning', 13, 120000.00, 'Active'),
(29, 'CrossFit', 7, 83000.00, 'Active'),
(30, 'General Fitness', 4, 58000.00, 'Inactive');

INSERT INTO MEMBERSHIP_PLAN (plan_id, plan_name, duration_months, monthly_fee, plan_type, description) VALUES
(1, 'Basic Monthly', 1, 4000.00, 'Basic', 'Access to gym floor and basic equipment for one month.'),
(2, 'Standard Monthly', 1, 6000.00, 'Standard', 'Gym access with cardio and strength zones.'),
(3, 'Premium Monthly', 1, 9000.00, 'Premium', 'Full access with trainer consultation.'),
(4, 'Student Monthly', 1, 3500.00, 'Student', 'Discounted monthly plan for students.'),
(5, 'Basic Quarterly', 3, 11000.00, 'Basic', 'Three-month basic gym access.'),
(6, 'Standard Quarterly', 3, 16500.00, 'Standard', 'Three-month standard access.'),
(7, 'Premium Quarterly', 3, 25000.00, 'Premium', 'Three-month premium access with guidance.'),
(8, 'Student Quarterly', 3, 9500.00, 'Student', 'Three-month student discount plan.'),
(9, 'Basic Half Yearly', 6, 21000.00, 'Basic', 'Six-month basic access.'),
(10, 'Standard Half Yearly', 6, 32000.00, 'Standard', 'Six-month standard access.'),
(11, 'Premium Half Yearly', 6, 48000.00, 'Premium', 'Six-month premium fitness package.'),
(12, 'Student Half Yearly', 6, 18000.00, 'Student', 'Six-month student fitness plan.'),
(13, 'Personal Training Monthly', 1, 15000.00, 'Personal Training', 'One-to-one personal training package.'),
(14, 'Personal Training Quarterly', 3, 42000.00, 'Personal Training', 'Three-month personal training package.'),
(15, 'Premium Yearly', 12, 85000.00, 'Premium', 'Full year premium gym membership.');

INSERT INTO SUBSCRIPTION (subscription_id, member_id, plan_id, start_date, end_date, subscription_status, discount_percent) VALUES
(1, 1, 4, '2026-06-01', '2026-07-01', 'Pending', 5.00),
(2, 2, 3, '2026-06-01', '2026-07-01', 'Pending', 0.00),
(3, 3, 2, '2026-06-02', '2026-07-02', 'Pending', 0.00),
(4, 4, 8, '2026-06-03', '2026-09-03', 'Pending', 10.00),
(5, 5, 1, '2026-06-04', '2026-07-04', 'Pending', 0.00),
(6, 6, 13, '2026-06-05', '2026-07-05', 'Pending', 0.00),
(7, 7, 7, '2026-06-06', '2026-09-06', 'Pending', 5.00),
(8, 8, 6, '2026-06-07', '2026-09-07', 'Pending', 0.00),
(9, 9, 5, '2026-06-08', '2026-09-08', 'Pending', 0.00),
(10, 10, 11, '2026-06-09', '2026-12-09', 'Pending', 15.00),
(11, 11, 9, '2026-05-01', '2026-11-01', 'Expired', 0.00),
(12, 12, 12, '2026-06-10', '2026-12-10', 'Pending', 10.00),
(13, 13, 14, '2026-06-11', '2026-09-11', 'Pending', 0.00),
(14, 14, 1, '2026-06-12', '2026-07-12', 'Cancelled', 0.00),
(15, 15, 15, '2026-06-13', '2027-06-13', 'Pending', 20.00);

INSERT INTO PAYMENT (subscription_id, payment_no, amount, payment_date, payment_method, payment_status) VALUES
(1, 1, 3325.00, '2026-06-01', 'Cash', 'Paid'),
(2, 1, 9000.00, '2026-06-01', 'Card', 'Paid'),
(3, 1, 6000.00, '2026-06-02', 'JazzCash', 'Paid'),
(4, 1, 8550.00, '2026-06-03', 'EasyPaisa', 'Paid'),
(5, 1, 4000.00, '2026-06-04', 'Cash', 'Paid'),
(6, 1, 15000.00, '2026-06-05', 'Bank Transfer', 'Paid'),
(7, 1, 23750.00, '2026-06-06', 'Card', 'Paid'),
(8, 1, 16500.00, '2026-06-07', 'JazzCash', 'Paid'),
(9, 1, 11000.00, '2026-06-08', 'Cash', 'Paid'),
(10, 1, 40800.00, '2026-06-09', 'Bank Transfer', 'Paid'),
(11, 1, 21000.00, '2026-05-01', 'Cash', 'Paid'),
(12, 1, 16200.00, '2026-06-10', 'EasyPaisa', 'Paid'),
(13, 1, 42000.00, '2026-06-11', 'Card', 'Paid'),
(14, 1, 4000.00, '2026-06-12', 'Cash', 'Refunded'),
(15, 1, 68000.00, '2026-06-13', 'Bank Transfer', 'Paid');

INSERT INTO ATTENDANCE (attendance_id, member_id, check_in_date, check_in_time, check_out_time, attendance_status) VALUES
(1, 1, '2026-06-14', '18:05:00', '19:20:00', 'Present'),
(2, 2, '2026-06-14', '18:15:00', '19:45:00', 'Present'),
(3, 3, '2026-06-14', '19:05:00', '20:10:00', 'Late'),
(4, 4, '2026-06-14', '17:30:00', '18:45:00', 'Present'),
(5, 5, '2026-06-14', '20:00:00', '21:00:00', 'Present'),
(6, 6, '2026-06-15', '18:10:00', '19:30:00', 'Present'),
(7, 7, '2026-06-15', '18:45:00', '20:00:00', 'Late'),
(8, 8, '2026-06-15', '17:55:00', '19:15:00', 'Present'),
(9, 9, '2026-06-15', '19:20:00', '20:40:00', 'Present'),
(10, 10, '2026-06-15', '20:10:00', '21:30:00', 'Present'),
(11, 11, '2026-06-16', '18:00:00', '19:05:00', 'Present'),
(12, 12, '2026-06-16', '18:25:00', '19:40:00', 'Present'),
(13, 13, '2026-06-16', '19:10:00', '20:20:00', 'Late'),
(14, 14, '2026-06-16', '00:00:00', NULL, 'Absent'),
(15, 15, '2026-06-16', '18:35:00', '20:00:00', 'Present');

INSERT INTO WORKOUT_PLAN (workout_id, member_id, trainer_id, plan_title, difficulty_level, assigned_date, notes) VALUES
(1, 1, 17, 'Beginner Fat Loss Plan', 'Beginner', '2026-06-01', 'Focus on treadmill, cycling, and light strength training.'),
(2, 2, 18, 'Muscle Gain Foundation', 'Intermediate', '2026-06-01', 'Compound lifts with progressive overload.'),
(3, 3, 30, 'General Fitness Routine', 'Beginner', '2026-06-02', 'Full body workout three days a week.'),
(4, 4, 20, 'Endurance Cardio Plan', 'Intermediate', '2026-06-03', 'Cardio circuits and stamina building.'),
(5, 5, 17, 'Weight Loss Circuit', 'Beginner', '2026-06-04', 'HIIT with low-impact movements.'),
(6, 6, 16, 'Strength Builder Plan', 'Advanced', '2026-06-05', 'Heavy strength training with proper rest days.'),
(7, 7, 18, 'Hypertrophy Split', 'Intermediate', '2026-06-06', 'Push, pull, legs split.'),
(8, 8, 23, 'Functional Mobility Plan', 'Beginner', '2026-06-07', 'Functional movement and bodyweight work.'),
(9, 9, 24, 'Fat Burn HIIT', 'Intermediate', '2026-06-08', 'High intensity interval training.'),
(10, 10, 19, 'Flexibility and Core', 'Beginner', '2026-06-09', 'Yoga, stretching, and core stability.'),
(11, 11, 22, 'Powerlifting Basics', 'Advanced', '2026-06-10', 'Squat, bench, deadlift technique.'),
(12, 12, 25, 'Women Fitness Plan', 'Beginner', '2026-06-10', 'Balanced strength and cardio training.'),
(13, 13, 29, 'CrossFit Conditioning', 'Advanced', '2026-06-11', 'Mixed modal high-intensity training.'),
(14, 14, 21, 'Nutrition Supported Fitness', 'Beginner', '2026-06-12', 'Light workout with nutrition guidance.'),
(15, 15, 28, 'Athletic Performance Plan', 'Advanced', '2026-06-13', 'Speed, agility, and strength conditioning.');

INSERT INTO DIET_PLAN (diet_id, member_id, trainer_id, goal, daily_calories, meal_details, assigned_date) VALUES
(1, 1, 21, 'Weight Loss', 1800, 'High protein breakfast, grilled chicken lunch, light dinner.', '2026-06-01'),
(2, 2, 21, 'Muscle Gain', 3000, 'Eggs, oats, rice, chicken, protein shake, nuts.', '2026-06-01'),
(3, 3, 30, 'Fitness', 2400, 'Balanced meals with fruits, vegetables, and lean protein.', '2026-06-02'),
(4, 4, 20, 'Endurance', 2600, 'Complex carbs, hydration, lean protein, and fruits.', '2026-06-03'),
(5, 5, 17, 'Weight Loss', 1700, 'Low sugar meals, salads, grilled fish, green tea.', '2026-06-04'),
(6, 6, 16, 'Strength Training', 3200, 'Protein-rich meals with rice, potatoes, chicken, and milk.', '2026-06-05'),
(7, 7, 18, 'Muscle Gain', 3100, 'High calorie diet with protein shake and healthy fats.', '2026-06-06'),
(8, 8, 23, 'Fitness', 2200, 'Moderate calorie plan with balanced macros.', '2026-06-07'),
(9, 9, 24, 'Weight Loss', 1750, 'Calorie deficit diet with high fiber meals.', '2026-06-08'),
(10, 10, 19, 'Endurance', 2500, 'Carb-focused diet for stamina and recovery.', '2026-06-09'),
(11, 11, 22, 'Strength Training', 3400, 'Heavy training diet with high protein and carbs.', '2026-06-10'),
(12, 12, 25, 'Fitness', 2100, 'Clean eating plan with portion control.', '2026-06-10'),
(13, 13, 29, 'Endurance', 2800, 'CrossFit performance diet with balanced energy intake.', '2026-06-11'),
(14, 14, 21, 'Weight Loss', 1650, 'Low calorie diet with vegetables and lean protein.', '2026-06-12'),
(15, 15, 28, 'Strength Training', 3300, 'Athletic diet with protein, carbs, and electrolytes.', '2026-06-13');

INSERT INTO EQUIPMENT (equipment_id, equipment_name, category, quantity_available, condition_status, last_maintenance_date) VALUES
(1, 'Treadmill', 'Cardio', 6, 'Good', '2026-05-20'),
(2, 'Exercise Bike', 'Cardio', 5, 'Good', '2026-05-22'),
(3, 'Rowing Machine', 'Cardio', 3, 'Good', '2026-05-18'),
(4, 'Bench Press', 'Strength', 4, 'Good', '2026-05-15'),
(5, 'Dumbbell Set', 'Strength', 20, 'Good', '2026-05-10'),
(6, 'Barbell', 'Strength', 10, 'Good', '2026-05-12'),
(7, 'Squat Rack', 'Strength', 3, 'Good', '2026-05-14'),
(8, 'Leg Press Machine', 'Strength', 2, 'Needs Maintenance', '2026-04-30'),
(9, 'Cable Machine', 'Strength', 2, 'Good', '2026-05-11'),
(10, 'Kettlebell Set', 'Functional', 12, 'Good', '2026-05-09'),
(11, 'Yoga Mat', 'Flexibility', 25, 'Good', '2026-05-25'),
(12, 'Resistance Bands', 'Functional', 30, 'Good', '2026-05-27'),
(13, 'Pull-up Bar', 'Strength', 4, 'Good', '2026-05-16'),
(14, 'Medicine Ball', 'Functional', 10, 'Good', '2026-05-19'),
(15, 'Elliptical Trainer', 'Cardio', 3, 'Damaged', '2026-04-25');

INSERT INTO WORKOUT_EQUIPMENT (workout_equipment_id, workout_id, equipment_id, sets_required, usage_notes) VALUES
(1, 1, 1, 3, 'Use treadmill for warm-up and fat-burning cardio.'),
(2, 1, 5, 3, 'Light dumbbells for beginner strength circuit.'),
(3, 2, 4, 4, 'Bench press for chest strength.'),
(4, 2, 6, 4, 'Barbell rows and deadlift practice.'),
(5, 3, 2, 3, 'Moderate cycling for general fitness.'),
(6, 4, 3, 4, 'Rowing intervals for endurance.'),
(7, 5, 10, 3, 'Kettlebell swings for fat loss.'),
(8, 6, 7, 5, 'Squat rack for strength training.'),
(9, 7, 5, 4, 'Dumbbells for hypertrophy exercises.'),
(10, 8, 12, 3, 'Resistance bands for mobility drills.'),
(11, 9, 14, 4, 'Medicine ball for HIIT circuits.'),
(12, 10, 11, 3, 'Yoga mat for stretching and core work.'),
(13, 11, 7, 5, 'Squat rack for powerlifting basics.'),
(14, 12, 9, 3, 'Cable machine for controlled strength training.'),
(15, 13, 13, 4, 'Pull-up bar for CrossFit conditioning.');

INSERT INTO FEEDBACK (feedback_id, member_id, trainer_id, rating, comments, feedback_date) VALUES
(1, 1, 17, 5, 'Trainer explained weight loss routine very clearly.', '2026-06-14'),
(2, 2, 18, 5, 'Great muscle gain plan and proper form guidance.', '2026-06-14'),
(3, 3, 30, 4, 'Good beginner-friendly workout plan.', '2026-06-14'),
(4, 4, 20, 4, 'Cardio endurance sessions are effective.', '2026-06-15'),
(5, 5, 17, 5, 'Very motivating and helpful trainer.', '2026-06-15'),
(6, 6, 16, 5, 'Strength training plan is challenging and useful.', '2026-06-15'),
(7, 7, 18, 4, 'Good hypertrophy workout structure.', '2026-06-16'),
(8, 8, 23, 5, 'Functional training helped improve mobility.', '2026-06-16'),
(9, 9, 24, 4, 'HIIT sessions are intense but effective.', '2026-06-16'),
(10, 10, 19, 5, 'Yoga and flexibility plan is excellent.', '2026-06-17'),
(11, 11, 22, 5, 'Powerlifting coaching is very professional.', '2026-06-17'),
(12, 12, 25, 4, 'Balanced fitness plan for women.', '2026-06-17'),
(13, 13, 29, 5, 'CrossFit conditioning is very energetic.', '2026-06-18'),
(14, 14, 21, 3, 'Diet guidance was helpful but needs more details.', '2026-06-18'),
(15, 15, 28, 5, 'Athletic performance training is excellent.', '2026-06-18');

CREATE VIEW view_active_member_report AS
SELECT 
    m.person_id AS member_id,
    CONCAT(p.first_name, ' ', p.last_name) AS member_name,
    p.email,
    mp.plan_name,
    s.start_date,
    s.end_date,
    s.subscription_status,
    pay.amount,
    pay.payment_status
FROM MEMBER m
JOIN PERSON p ON m.person_id = p.person_id
JOIN SUBSCRIPTION s ON m.person_id = s.member_id
JOIN MEMBERSHIP_PLAN mp ON s.plan_id = mp.plan_id
JOIN PAYMENT pay ON s.subscription_id = pay.subscription_id
WHERE s.subscription_status = 'Active';

CREATE VIEW view_trainer_workload_report AS
SELECT
    t.person_id AS trainer_id,
    CONCAT(p.first_name, ' ', p.last_name) AS trainer_name,
    t.specialization_area,
    COUNT(DISTINCT w.workout_id) AS total_workout_plans,
    COUNT(DISTINCT d.diet_id) AS total_diet_plans,
    ROUND(AVG(f.rating), 2) AS average_rating
FROM TRAINER t
JOIN PERSON p ON t.person_id = p.person_id
LEFT JOIN WORKOUT_PLAN w ON t.person_id = w.trainer_id
LEFT JOIN DIET_PLAN d ON t.person_id = d.trainer_id
LEFT JOIN FEEDBACK f ON t.person_id = f.trainer_id
GROUP BY t.person_id, p.first_name, p.last_name, t.specialization_area;

CREATE VIEW view_equipment_usage_report AS
SELECT
    e.equipment_id,
    e.equipment_name,
    e.category,
    e.quantity_available,
    e.condition_status,
    COUNT(we.workout_equipment_id) AS total_times_used_in_workouts
FROM EQUIPMENT e
LEFT JOIN WORKOUT_EQUIPMENT we ON e.equipment_id = we.equipment_id
GROUP BY e.equipment_id, e.equipment_name, e.category, e.quantity_available, e.condition_status;

SELECT
    m.person_id AS member_id,
    CONCAT(p.first_name, ' ', p.last_name) AS member_name,
    mp.plan_name,
    s.start_date,
    s.end_date,
    s.subscription_status,
    pay.amount,
    pay.payment_method,
    pay.payment_status
FROM MEMBER m
JOIN PERSON p ON m.person_id = p.person_id
JOIN SUBSCRIPTION s ON m.person_id = s.member_id
JOIN MEMBERSHIP_PLAN mp ON s.plan_id = mp.plan_id
JOIN PAYMENT pay ON s.subscription_id = pay.subscription_id;

SELECT
    w.workout_id,
    CONCAT(pm.first_name, ' ', pm.last_name) AS member_name,
    CONCAT(pt.first_name, ' ', pt.last_name) AS trainer_name,
    w.plan_title,
    w.difficulty_level,
    e.equipment_name,
    we.sets_required
FROM WORKOUT_PLAN w
JOIN MEMBER m ON w.member_id = m.person_id
JOIN PERSON pm ON m.person_id = pm.person_id
LEFT JOIN TRAINER t ON w.trainer_id = t.person_id
LEFT JOIN PERSON pt ON t.person_id = pt.person_id
JOIN WORKOUT_EQUIPMENT we ON w.workout_id = we.workout_id
JOIN EQUIPMENT e ON we.equipment_id = e.equipment_id;

SELECT
    mp.plan_name,
    COUNT(s.subscription_id) AS total_subscriptions,
    SUM(pay.amount) AS total_revenue,
    AVG(pay.amount) AS average_payment,
    MAX(pay.amount) AS highest_payment,
    MIN(pay.amount) AS lowest_payment
FROM MEMBERSHIP_PLAN mp
JOIN SUBSCRIPTION s ON mp.plan_id = s.plan_id
JOIN PAYMENT pay ON s.subscription_id = pay.subscription_id
WHERE pay.payment_status = 'Paid'
GROUP BY mp.plan_name
HAVING SUM(pay.amount) > 5000;

SELECT
    CONCAT(p.first_name, ' ', p.last_name) AS trainer_name,
    t.specialization_area,
    COUNT(DISTINCT w.workout_id) AS workout_plans_assigned,
    ROUND(AVG(f.rating), 2) AS average_rating
FROM TRAINER t
JOIN PERSON p ON t.person_id = p.person_id
LEFT JOIN WORKOUT_PLAN w ON t.person_id = w.trainer_id
LEFT JOIN FEEDBACK f ON t.person_id = f.trainer_id
GROUP BY p.first_name, p.last_name, t.specialization_area
HAVING AVG(f.rating) >= 4;

SELECT
    CONCAT(p.first_name, ' ', p.last_name) AS member_name,
    p.email
FROM PERSON p
WHERE p.person_id IN (
    SELECT m.person_id
    FROM MEMBER m
    WHERE m.person_id IN (
        SELECT s.member_id
        FROM SUBSCRIPTION s
        WHERE s.subscription_id IN (
            SELECT pay.subscription_id
            FROM PAYMENT pay
            WHERE pay.payment_status = 'Paid'
        )
    )
);

SELECT
    CONCAT(p.first_name, ' ', p.last_name) AS trainer_name,
    t.specialization_area
FROM TRAINER t
JOIN PERSON p ON t.person_id = p.person_id
WHERE EXISTS (
    SELECT 1
    FROM FEEDBACK f
    WHERE f.trainer_id = t.person_id
);

SELECT
    pay.subscription_id,
    pay.payment_no,
    pay.amount,
    pay.payment_method
FROM PAYMENT pay
WHERE pay.amount > ANY (
    SELECT pay2.amount
    FROM PAYMENT pay2
    JOIN SUBSCRIPTION s2 ON pay2.subscription_id = s2.subscription_id
    JOIN MEMBERSHIP_PLAN mp2 ON s2.plan_id = mp2.plan_id
    WHERE mp2.plan_type = 'Basic'
);

SELECT
    equipment_name,
    category,
    quantity_available,
    condition_status,
    last_maintenance_date
FROM EQUIPMENT
WHERE quantity_available <= 3
OR condition_status IN ('Needs Maintenance', 'Damaged');

SELECT
    CONCAT(p.first_name, ' ', p.last_name) AS member_name,
    COUNT(a.attendance_id) AS total_attendance_records,
    SUM(CASE WHEN a.attendance_status = 'Present' THEN 1 ELSE 0 END) AS present_count,
    SUM(CASE WHEN a.attendance_status = 'Late' THEN 1 ELSE 0 END) AS late_count,
    SUM(CASE WHEN a.attendance_status = 'Absent' THEN 1 ELSE 0 END) AS absent_count
FROM MEMBER m
JOIN PERSON p ON m.person_id = p.person_id
LEFT JOIN ATTENDANCE a ON m.person_id = a.member_id
GROUP BY p.first_name, p.last_name
HAVING COUNT(a.attendance_id) >= 1;

SELECT * FROM view_active_member_report;
SELECT * FROM view_trainer_workload_report;
SELECT * FROM view_equipment_usage_report;

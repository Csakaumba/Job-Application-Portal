-- Sample employers
INSERT INTO users (username, email, password, role) VALUES
('companyalpha', 'hr@companyalpha.com', '$2y$10$samplehashforemployer1', 'employer'),
('companybeta', 'jobs@companybeta.com', '$2y$10$samplehashforemployer2', 'employer');

-- Sample jobseekers
INSERT INTO users (username, email, password, role) VALUES
('alice', 'alice@gmail.com', '$2y$10$samplehashforalice', 'jobseeker'),
('bob', 'bob@yahoo.com', '$2y$10$samplehashforbob', 'jobseeker');

-- Sample jobs (employer_id should match inserted employers' IDs)
INSERT INTO jobs (employer_id, title, description, location) VALUES
(1, 'Frontend Developer', 'Develop modern web interfaces using React and CSS.', 'Remote'),
(1, 'Backend Developer', 'Work with PHP and MySQL to build robust APIs.', 'New York'),
(2, 'Marketing Specialist', 'Create and execute marketing strategies for digital campaigns.', 'London'),
(2, 'Data Analyst', 'Analyze large datasets to extract actionable insights.', 'Berlin');

-- Sample applications (seeker_id and job_id should match above)
INSERT INTO applications (job_id, seeker_id, cv_file) VALUES
(1, 3, 'cv_alice.pdf'),
(2, 4, 'cv_bob.pdf'),
(3, 3, 'cv_alice.pdf');

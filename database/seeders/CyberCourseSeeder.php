<?php

namespace Database\Seeders;

use App\Models\QuizModule\Option;
use App\Models\QuizModule\Question;
use App\Models\QuizModule\Quiz;
use App\Models\Training\CourseMaterial;
use App\Models\Training\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CyberCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $course = Course::create([
            'course_name' => 'Cyber Security Awareness',
            'course_description' => 'A fundamental cybersecurity awareness course for Telecom Namibia employees.',
            'user_id' => 1,
            'course_fee' => 0,
            'course_image' => 'https://cdn.dribbble.com/userupload/14375213/file/original-fd4b67a6f4e6c8bfeca200725dd400a3.jpg?resize=1600x1333&vertical=center',

        ]);

        // Create Course Modules
        $modules = [
            [
    "title" => "Introduction to Cybersecurity",
    "description" => "An introduction to cybersecurity fundamentals, common threats, and best practices for safeguarding company assets.",
    "content" => "## Module: Introduction to Cybersecurity
### Overview
Cybersecurity is crucial in protecting Telecom Namibia's data, infrastructure, and customer information. As digital threats become more sophisticated, employees must be equipped with the knowledge and tools to safeguard company assets. This module introduces the fundamentals of cybersecurity, the evolving threat landscape, and why cybersecurity is essential for Telecom Namibia’s success.

Cybersecurity encompasses a range of practices, technologies, and strategies designed to protect systems, networks, and data from cyber threats. These threats can come from malicious attackers, software vulnerabilities, or even human error. A well-informed workforce is the first line of defense against cyberattacks.

### Learning Objectives
- Understand the importance of cybersecurity
- Recognize common cyber threats
- Learn best practices for mitigating risks
- Identify security responsibilities within the organization
- Develop a proactive security mindset to prevent cyber incidents

### Why Cybersecurity Matters
Recent cyber incidents highlight the growing threats to organizations, including Telecom Namibia. Cybersecurity awareness helps prevent data breaches, financial losses, and reputational damage. Organizations that fail to implement strong security measures risk losing critical business data, facing legal consequences, and eroding customer trust.

A successful cyber attack can result in:
- **Financial losses** due to fraud, ransomware payments, and business disruption
- **Data breaches** exposing sensitive customer and company information
- **Reputational damage** leading to a loss of customer confidence and business opportunities
- **Operational downtime** caused by compromised systems and recovery efforts

By fostering a cybersecurity-conscious culture, Telecom Namibia can significantly reduce its vulnerability to cyber threats and create a safer digital environment for its employees and customers.

### Key Topics
- Importance of Multi-Factor Authentication (MFA)
- Understanding Zero-Day Exploits
- Role of Security Information and Event Management (SIEM)
- Cybersecurity frameworks (ISO 27001, NIST, PCI DSS)"
],
[
    "title" => "Common Cyber Threats",
    "description" => "Learn about common cyber threats such as phishing, malware, and insider threats, and how to defend against them.",
    "content" => "## Module: Common Cyber Threats
### Overview
Understanding cyber threats is the first step in defending against them. This module covers key cybersecurity threats employees may face.

### Learning Objectives
- Identify common cyber threats
- Learn how to recognize and avoid cyberattacks

### Common Threats
1. **Phishing & Social Engineering** – Deceptive emails or messages tricking users into revealing sensitive information.
2. **Malware & Ransomware** – Malicious software that can compromise systems and demand payments.
3. **Insider Threats** – Employees or third parties misusing access to company systems.
4. **Advanced Persistent Threats (APTs)** – Long-term targeted cyber attacks by skilled adversaries.
5. **Shadow IT Risks** – Unapproved applications or tools creating security vulnerabilities.

**Prevention Tips:**
- Verify email senders before clicking links.
- Do not share passwords or sensitive data over email.
- Report suspicious activities immediately."
],
[
    "title" => "Password Security & Authentication",
    "description" => "Understand the importance of strong passwords and multi-factor authentication (MFA) in securing accounts.",
    "content" => "## Module: Password Security & Authentication
### Overview
Weak passwords are a leading cause of security breaches. This module covers best practices for secure authentication.

<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/V79LLxNCQJU?si=FtynemLJn37jGsJ5\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>

### Learning Objectives
- Create strong passwords
- Understand the importance of Multi-Factor Authentication (MFA)

### Best Practices
- Use at least 12-character passwords with a mix of letters, numbers, and symbols.
- Never reuse passwords across multiple accounts.
- Enable MFA wherever possible for an extra layer of security.
- Use password managers for storing complex passwords securely."
],
[
    "title" => "Safe Internet & Email Practices",
    "description" => "Learn best practices for staying secure while browsing the internet and using email to avoid cyber threats.",
    "content" => "## Module: Safe Internet & Email Practices
### Overview
Cybercriminals exploit the internet and email to launch attacks. This module focuses on staying secure online.

<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/aO858HyFbKI?si=t7rV9ACdAzc1YBuQ\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>

### Learning Objectives
- Recognize phishing emails and scams
- Learn safe browsing habits

### Best Practices
- Do not open unexpected email attachments or click on suspicious links.
- Use a secure, up-to-date browser.
- Avoid using public Wi-Fi for work-related tasks.
- Verify website security by checking for HTTPS and avoiding suspicious URLs."
],
[
    "title" => "Data Protection & Privacy",
    "description" => "Understand data protection principles and how to handle sensitive information securely.",
    "content" => "## Module: Data Protection & Privacy
### Overview
Protecting sensitive company and customer data is a shared responsibility.

<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/BqwGGO0wvls?si=m8VITJR2qqlvmtgJ\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>

### Learning Objectives
- Learn how to handle sensitive data securely
- Understand data protection policies

### Best Practices
- Store company data only on approved, secure platforms.
- Encrypt sensitive files before sharing them.
- Be cautious of unauthorized data access requests.
- Follow company guidelines for handling classified information."
],
[
    "title" => "Incident Reporting & Response",
    "description" => "Learn how to recognize and report security incidents and understand response procedures.",
    "content" => "## Module: Incident Reporting & Response
### Overview
Knowing how to respond to a cyber incident can minimize damage.

### Learning Objectives
- Understand Telecom Namibia’s incident response procedures
- Learn how to report security threats

### Key Steps
1. **Recognize** – Identify suspicious activities or potential security breaches.
2. **Report** – Notify the IT security team immediately.
3. **Respond** – Follow company guidelines to contain and mitigate the incident.
4. **Recover & Analyze** – Restore systems and assess attack origins to prevent recurrence."
]
];



        foreach ($modules as $moduleData) {
            CourseMaterial::create([
                'course_id' => $course->id,
                'material_name' => $moduleData['title'],
                'description' => $moduleData['description'],
                'material_content' => $moduleData['content'],
            ]);
        }

        // Create the Quiz
        // $quiz = Quiz::create([
        //     'training_id' => $course->id,
        //     'title' => 'Cybersecurity Awareness Quiz',
        //     'description' => 'Test your understanding of cybersecurity principles.',
        //     'max_attempts' => 3,
        //     'passing_score' => 80,
        // ]);

        // // Define Questions and Answers
        // $questions = [
        //     [
        //         'question' => 'What is Multi-Factor Authentication (MFA)?',
        //         'options' => ['Logging in with only a username and password', 'A security method that requires two or more verification steps', 'A way to share passwords with colleagues', 'Automatically logging in without entering credentials'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What is the primary purpose of a SIEM system in cybersecurity?',
        //         'options' => ['To monitor and analyze security events', 'To block malware', 'To optimize network performance', 'To replace firewalls'],
        //         'correct_option' => 0,
        //     ],
        //     [
        //         'question' => 'Which of the following is an example of a phishing attack?',
        //         'options' => ['A pop-up ad promoting a sale', 'A fraudulent email pretending to be from IT support, asking for your password', 'A software update notification from your official company system', 'A social media friend request from a colleague'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'How does a zero-day exploit work?',
        //         'options' => ['It targets a known vulnerability with an existing patch', 'It exploits an unknown vulnerability before a patch is available', 'It only affects outdated software', 'It requires insider access to succeed'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'Which cybersecurity framework is widely used for managing risk?',
        //         'options' => ['ISO 27001', 'PCI DSS', 'NIST Cybersecurity Framework', 'GDPR'],
        //         'correct_option' => 2,
        //     ],
        //     [
        //         'question' => 'Why is public Wi-Fi a security risk for work-related tasks?',
        //         'options' => ['It is slower than a wired connection', 'Hackers can intercept data sent over unsecured networks', 'It does not allow access to work emails', 'It is more expensive than mobile data'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What is the safest way to access company data remotely?',
        //         'options' => ['Using a public Wi-Fi connection', 'Using a Virtual Private Network (VPN)', 'Logging in from a friend’s computer', 'Disabling firewall settings'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'Which of the following best describes an Advanced Persistent Threat (APT)?',
        //         'options' => ['A one-time hacking attempt', 'A long-term targeted cyber attack by a skilled adversary', 'A virus that spreads via USB devices', 'A security measure used by governments'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What is the primary role of a penetration test?',
        //         'options' => ['To assess security vulnerabilities by simulating an attack', 'To install antivirus software', 'To create network firewalls', 'To encrypt all company emails'],
        //         'correct_option' => 0,
        //     ],
        //     [
        //         'question' => 'What should you do if you receive an email from an unknown sender with an attachment?',
        //         'options' => ['Open it immediately to see if it is important', 'Reply asking for confirmation', 'Delete it or report it as spam', 'Forward it to all employees'],
        //         'correct_option' => 2,
        //     ],
        //     [
        //         'question' => 'Which of the following is NOT an example of social engineering?',
        //         'options' => ['Phishing emails', 'Vishing (voice phishing)', 'Brute force password attacks', 'Baiting (leaving infected USB drives in public)'],
        //         'correct_option' => 2,
        //     ],
        //     [
        //         'question' => 'What should you do if you suspect a cyber attack?',
        //         'options' => ['Ignore it and continue working', 'Try to fix the issue yourself without informing IT', 'Report it to the IT security team immediately', 'Shut down your computer without saving your work'],
        //         'correct_option' => 2,
        //     ],
        //     [
        //         'question' => 'Which of these is NOT a method for preventing data breaches?',
        //         'options' => ['Using strong passwords', 'Sharing passwords with trusted coworkers', 'Enabling Multi-Factor Authentication', 'Keeping software updated'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'Which of these is a strong password example?',
        //         'options' => ['123456', 'Password1', 'Telecom2024', 'X#1pA!9z@T'],
        //         'correct_option' => 3,
        //     ],
        //     [
        //         'question' => 'Why should you avoid using the same password for multiple accounts?',
        //         'options' => ['It is difficult to remember', 'If one account is compromised, others will be too', 'It takes longer to type', 'Hackers only target new passwords'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'Which of these is NOT a best practice for email security?',
        //         'options' => ['Enabling spam filters', 'Clicking on links from unknown senders', 'Using unique passwords for email accounts', 'Verifying unexpected email attachments before opening'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What does encryption do?',
        //         'options' => ['Hides data by converting it into unreadable code', 'Deletes unnecessary files', 'Speeds up internet browsing', 'Automatically backs up data to the cloud'],
        //         'correct_option' => 0,
        //     ],
        //     [
        //         'question' => 'Which of the following is NOT a cyber threat?',
        //         'options' => ['Phishing', 'Ransomware', 'Firewall', 'Spyware'],
        //         'correct_option' => 2,
        //     ],
        //     [
        //         'question' => 'What is the primary risk of Shadow IT?',
        //         'options' => ['It slows down official IT systems', 'Unauthorized applications may pose security vulnerabilities', 'It makes IT teams obsolete', 'It only affects personal devices, not corporate networks'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What is the main goal of ransomware?',
        //         'options' => ['To steal money from a bank account', 'To block access to files until a ransom is paid', 'To slow down internet speed', 'To disable antivirus software'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'How should sensitive company data be handled?',
        //         'options' => ['Store it on approved, secure platforms', 'Email it to personal accounts for easy access', 'Save it on USB drives without encryption', 'Share it freely with anyone who asks'],
        //         'correct_option' => 0,
        //     ],
        //     [
        //         'question' => 'Which of these is NOT a recommended incident response step?',
        //         'options' => ['Identify the breach', 'Contain the threat', 'Erase all company data immediately', 'Recover and analyze the attack'],
        //         'correct_option' => 2,
        //     ],
        //     [
        //         'question' => 'What is the purpose of a firewall?',
        //         'options' => ['To speed up the internet', 'To block unauthorized access to a network', 'To replace antivirus software', 'To store sensitive data'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What is the best way to avoid malware infections?',
        //         'options' => ['Click on all links to check if they are safe', 'Download software only from trusted sources', 'Open email attachments from unknown senders', 'Disable antivirus software to improve system speed'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'Which of the following is a common indicator of a phishing website?',
        //         'options' => ['A lock icon in the address bar', 'A long, suspicious-looking URL', 'A website ending in .gov', 'A professionally designed website'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'Why is cybersecurity important for Telecom Namibia?',
        //         'options' => ['To comply with government regulations', 'To protect company data, infrastructure, and customer information', 'To avoid unnecessary software updates', 'To improve internet speed'],
        //         'correct_option' => 1,
        //     ],
        //     [
        //         'question' => 'What is the most secure way to create a strong password?',
        //         'options' => ['Using your birthdate and name', 'A short word that is easy to remember', 'A mix of uppercase, lowercase, numbers, and special characters', 'The same password for all accounts for easy recall'],
        //         'correct_option' => 2,
        //     ],
        // ];


        // foreach ($questions as $q) {
        //     $question = Question::create([
        //         'quiz_id' => $quiz->id,
        //         'question_text' => $q['question'],
        //         'question_type' => 'multiple_choice',
        //     ]);

        //     foreach ($q['options'] as $index => $optionText) {
        //         Option::create([
        //             'question_id' => $question->id,
        //             'option_text' => $optionText,
        //             'is_correct' => $index == $q['correct_option'],
        //         ]);
        //     }
        // }
    }
}

<?php

namespace Database\Seeders;

use App\Models\QuizModule\Option;
use App\Models\QuizModule\Question;
use App\Models\QuizModule\Quiz;
use App\Models\Training\CourseMaterial;
use App\Models\Training\Training;
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
        $course = Training::create([
            'title' => 'Cyber Security Awareness',
            'description' => 'A fundamental cybersecurity awareness course for Telecom Namibia employees.',
            'user_id' => 1,
            'training_type' => 'online',
            'max_participants' => 1000,
            'location' => 'Online',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'image' => 'https://cdn.dribbble.com/userupload/14375213/file/original-fd4b67a6f4e6c8bfeca200725dd400a3.jpg?resize=1600x1333&vertical=center',

        ]);

        // Create Course Modules
        $modules = [
            ["title" => "Introduction to Cybersecurity", "content" => "## Module: Introduction to Cybersecurity
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

"],
            ["title" => "Common Cyber Threats", "content" => '## Module: Common Cyber Threats
### Overview
Understanding cyber threats is the first step in defending against them. This module covers key cybersecurity threats employees may face.

### Learning Objectives
- Identify common cyber threats
- Learn how to recognize and avoid cyberattacks

### Common Threats
1. **Phishing & Social Engineering** – Deceptive emails or messages tricking users into revealing sensitive information.
2. **Malware & Ransomware** – Malicious software that can compromise systems and demand payments.
3. **Insider Threats** – Employees or third parties misusing access to company systems.


**Prevention Tips:**
- Verify email senders before clicking links.
- Do not share passwords or sensitive data over email.
- Report suspicious activities immediately.

'],
["title" => "Password Security & Authentication", "content" => '## Module: Password Security & Authentication
### Overview
Weak passwords are a leading cause of security breaches. This module covers best practices for secure authentication.

<iframe width="560" height="315" src="https://www.youtube.com/embed/V79LLxNCQJU?si=FtynemLJn37jGsJ5" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

### Learning Objectives
- Create strong passwords
- Understand the importance of Multi-Factor Authentication (MFA)

### Best Practices
- Use at least 12-character passwords with a mix of letters, numbers, and symbols.
- Never reuse passwords across multiple accounts.
- Enable MFA wherever possible for an extra layer of security.
'],
["title" => "Safe Internet & Email Practices", "content" => '## Module: Safe Internet & Email Practices
### Overview
Cybercriminals exploit the internet and email to launch attacks. This module focuses on staying secure online.

<iframe width="560" height="315" src="https://www.youtube.com/embed/aO858HyFbKI?si=t7rV9ACdAzc1YBuQ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

### Learning Objectives
- Recognize phishing emails and scams
- Learn safe browsing habits

### Best Practices
- Do not open unexpected email attachments or click on suspicious links.
- Use a secure, up-to-date browser.
- Avoid using public Wi-Fi for work-related tasks.
            '],
            ["title" => "Data Protection & Privacy", "content" => '## Module: Data Protection & Privacy
### Overview
Protecting sensitive company and customer data is a shared responsibility.

<iframe width="560" height="315" src="https://www.youtube.com/embed/BqwGGO0wvls?si=m8VITJR2qqlvmtgJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

### Learning Objectives
- Learn how to handle sensitive data securely
- Understand data protection policies

### Best Practices
- Store company data only on approved, secure platforms.
- Encrypt sensitive files before sharing them.
- Be cautious of unauthorized data access requests.'],
["title" => "Workplace Device Security", "content" => '## Module: Workplace Device Security
### Overview
Every device connected to Telecom Namibia’s network is a potential entry point for cyber threats.
<iframe width="560" height="315" src="https://www.youtube.com/embed/9OHLd5ZgjvA?si=xAgQ2SmZfFz9Ympr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

### Learning Objectives
- Secure company-issued and personal devices
- Understand endpoint security measures

### Best Practices
- Lock your screen when away from your workstation.
- Keep operating systems and applications updated.
- Avoid using unauthorized USB drives or software.
'],

            ["title" => "Incident Reporting & Response", "content" => "## Module: Incident Reporting & Response
### Overview
Knowing how to respond to a cyber incident can minimize damage.

### Learning Objectives
- Understand Telecom Namibia’s incident response procedures
- Learn how to report security threats

### Key Steps
1. **Recognize** – Identify suspicious activities or potential security breaches.
2. **Report** – Notify the IT security team immediately.
3. **Respond** – Follow company guidelines to contain and mitigate the incident."],
["title" => "Cybersecurity for Remote Work", "content" => "## Module: Cybersecurity for Remote Work
### Overview
Remote work introduces new cybersecurity risks. This module focuses on securing work-from-home setups.

### Learning Objectives
- Secure home networks
- Use VPNs and secure connections

### Best Practices
- Use company-provided VPNs for secure access.
- Keep personal and work devices separate.
- Avoid downloading unverified software."],
        ];

        foreach ($modules as $moduleData) {
            CourseMaterial::create([
                'training_id' => $course->id,
                'material_name' => $moduleData['title'],
                'material_content' => $moduleData['content'],
            ]);
        }

        // Create the Quiz
        $quiz = Quiz::create([
            'training_id' => $course->id,
            'title' => 'Cybersecurity Awareness Quiz',
            'description' => 'Test your understanding of cybersecurity principles.',
            'max_attempts' => 3,
            'passing_score' => 80,
        ]);

        // Define Questions and Answers
        $questions = [
            [
                'question' => 'Why is cybersecurity important for Telecom Namibia?',
                'options' => ['To comply with government regulations', 'To protect company data, infrastructure, and customer information', 'To avoid unnecessary software updates', 'To improve internet speed'],
                'correct_option' => 1,
            ],
            [
                'question' => 'Which of the following is an example of a phishing attack?',
                'options' => ['A pop-up ad promoting a sale', 'A fraudulent email pretending to be from IT support, asking for your password', 'A software update notification from your official company system', 'A social media friend request from a colleague'],
                'correct_option' => 1,
            ],
            [
                'question' => 'What is the most secure way to create a strong password?',
                'options' => ['Using your birthdate and name', 'A short word that is easy to remember', 'A mix of uppercase, lowercase, numbers, and special characters', 'The same password for all accounts for easy recall'],
                'correct_option' => 2,
            ],
            [
                'question' => 'How can you identify a suspicious email?',
                'options' => ['It has generic greetings like “Dear Customer”', 'It asks for urgent action, such as clicking a link or providing credentials', 'It contains unexpected attachments', 'All of the above'],
                'correct_option' => 3,
            ],
            [
                'question' => 'What is Multi-Factor Authentication (MFA)?',
                'options' => ['Logging in with only a username and password', 'A security method that requires two or more verification steps', 'A way to share passwords with colleagues', 'Automatically logging in without entering credentials'],
                'correct_option' => 1,
            ],
            [
                'question' => 'How should sensitive company data be handled?',
                'options' => ['Store it on approved, secure platforms', 'Email it to personal accounts for easy access', 'Save it on USB drives without encryption', 'Share it freely with anyone who asks'],
                'correct_option' => 0,
            ],
            [
                'question' => 'What should you do if you suspect a cyber attack?',
                'options' => ['Ignore it and continue working', 'Try to fix the issue yourself without informing IT', 'Report it to the IT security team immediately', 'Shut down your computer without saving your work'],
                'correct_option' => 2,
            ],
            [
                'question' => 'Why is public Wi-Fi a security risk for work-related tasks?',
                'options' => ['It is slower than a wired connection', 'Hackers can intercept data sent over unsecured networks', 'It does not allow access to work emails', 'It is more expensive than mobile data'],
                'correct_option' => 1,
            ],
            [
                'question' => 'What is the best way to avoid malware infections?',
                'options' => ['Click on all links to check if they are safe', 'Download software only from trusted sources', 'Open email attachments from unknown senders', 'Disable antivirus software to improve system speed'],
                'correct_option' => 1,
            ],
            [
                'question' => 'Which of the following is NOT a common cyber threat?',
                'options' => ['Phishing emails', 'Malware and ransomware', 'Social engineering attacks', 'Using strong passwords'],
                'correct_option' => 3,
            ],
        ];

        foreach ($questions as $q) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $q['question'],
                'question_type' => 'multiple_choice',
            ]);

            foreach ($q['options'] as $index => $optionText) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'is_correct' => $index == $q['correct_option'],
                ]);
            }
        }
    }
}

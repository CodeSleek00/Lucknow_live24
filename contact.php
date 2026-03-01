<?php
include 'partials/site_bootstrap.php';
$pageTitle = 'Contact | Lucknow Live24';
$activeNav = 'contact.php';
include 'partials/site_header.php';
?>
<div class="page">
    <div class="section-head">
        <h2>Contact Desk</h2>
        <span class="section-badge">Get In Touch</span>
    </div>

    <div class="split-layout">
        <div class="article-panel">
            <h3 style="margin-top:0;">Newsroom Contacts</h3>
            <p><strong>Email:</strong> newsroom@lucknowlive24.com</p>
            <p><strong>WhatsApp Tip Line:</strong> +91-90000-00000</p>
            <p><strong>Address:</strong> Hazratganj, Lucknow, Uttar Pradesh</p>
            <p>For corrections, partnerships, and ad enquiries, use the form.</p>
        </div>

        <div class="article-panel">
            <h3 style="margin-top:0;">Send Message</h3>
            <form class="input-row" method="post" action="#" onsubmit="event.preventDefault(); alert('Message submitted. Connect backend mail API to activate.');">
                <input type="text" name="name" placeholder="Your name" required>
                <input type="email" name="email" placeholder="Your email" required>
                <select name="topic" required>
                    <option value="">Select topic</option>
                    <option>News Tip</option>
                    <option>Advertisement</option>
                    <option>Correction Request</option>
                    <option>Other</option>
                </select>
                <textarea name="message" rows="5" placeholder="Write your message" required></textarea>
                <button type="submit" class="btn">Send</button>
            </form>
        </div>
    </div>
</div>
<?php include 'partials/site_footer.php'; ?>

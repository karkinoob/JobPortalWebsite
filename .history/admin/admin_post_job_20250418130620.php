<form action="admin_store_job.php" method="POST">
  <label>Company Name:</label><br>
  <input type="text" name="company_name" required><br><br>

  <label>Job Title:</label><br>
  <input type="text" name="job_title" required><br><br>

  <label>Job Description:</label><br>
  <textarea name="job_description" required></textarea><br><br>

  <label>Address:</label><br>
  <input type="text" name="address" required><br><br>

  <label>Category:</label><br>
  <select name="category" required>
    <option value="IT">IT</option>
    <option value="AI">AI</option>
    <option value="Design">Design</option>
    <option value="Sales">Sales</option>
    <option value="Support">Support</option>
  </select><br><br>

  <label>Valid Till:</label><br>
  <input type="date" name="valid_till" required><br><br>

  <input type="submit" value="Post Job">
</form>

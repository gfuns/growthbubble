<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Signup | Automation Agency</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #faf8f5;
    }
    .hero-title {
      font-size: 1.8rem;
      font-weight: 600;
    }
    .hero-subtext {
      color: #555;
      font-size: 1rem;
    }
    .profile-badge {
      position: absolute;
      top: 10px;
      left: 10px;
      padding: 4px 8px;
      font-size: 0.8rem;
      font-weight: 500;
      border-radius: 6px;
      color: #fff;
    }
    .badge-blue { background-color: #17a2b8; }
    .badge-orange { background-color: #fd7e14; }
    .badge-green { background-color: #28a745; }
    .badge-red { background-color: #dc3545; }
    .step-indicator {
      background: #eaf9ef;
      color: #28a745;
      border-radius: 50px;
      padding: 6px 16px;
      font-weight: 500;
      font-size: 0.9rem;
      display: inline-block;
    }
    .card-box {
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .stats span {
      display: block;
      font-weight: 600;
      font-size: 1rem;
    }
    .stats small {
      color: #555;
    }
    .form-control:focus {
      border-color: #28a745;
      box-shadow: none;
    }
    .continue-btn {
      background: #28a745;
      border: none;
      padding: 12px;
      font-weight: 600;
      border-radius: 8px;
      width: 100%;
      color: #fff;
    }
    .continue-btn:hover {
      background: #218838;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="row">
    <!-- Left Column -->
    <div class="col-md-6 mb-4">
      <div class="mb-3">
        <span class="step-indicator">Step 1 of 3 : Company Name</span>
      </div>

      <div class="d-flex flex-wrap gap-3">
        <!-- Profile Card 1 -->
        <div class="position-relative">
          <img src="https://via.placeholder.com/200x200" class="rounded shadow" alt="Profile">
          <div class="profile-badge badge-blue">Nicole | Activecampaign</div>
        </div>
        <!-- Profile Card 2 -->
        <div class="position-relative">
          <img src="https://via.placeholder.com/200x200" class="rounded shadow" alt="Profile">
          <div class="profile-badge badge-orange">Gina | GoHighLevel</div>
        </div>
        <!-- Profile Card 3 -->
        <div class="position-relative">
          <img src="https://via.placeholder.com/200x200" class="rounded shadow" alt="Profile">
          <div class="profile-badge badge-green">Ryan | WordPress</div>
        </div>
        <!-- Profile Card 4 -->
        <div class="position-relative">
          <img src="https://via.placeholder.com/200x200" class="rounded shadow" alt="Profile">
          <div class="profile-badge badge-red">Jessica | Zapier</div>
        </div>
      </div>
    </div>

    <!-- Right Column -->
    <div class="col-md-6">
      <div class="card-box">
        <h3 class="hero-title">Your Online <span class="text-primary">Marketing Team</span> Starts Here..</h3>
        <p class="hero-subtext">Now you can finally make that dream happen by offloading your marketing tasks to our team of heroes.</p>

        <form>
          <div class="mb-3">
            <label for="companyName" class="form-label">What’s your company name?</label>
            <input type="text" class="form-control" id="companyName" placeholder="Big man ENTERPRISE">
            <div class="form-text">This will be your account name</div>
          </div>
          <button type="submit" class="continue-btn">Continue →</button>
        </form>

        <div class="row text-center mt-4 stats">
          <div class="col-4">
            <span>11+ Years</span>
            <small>Proven Success</small>
          </div>
          <div class="col-4">
            <span>707896+</span>
            <small>Tasks Completed</small>
          </div>
          <div class="col-4">
            <span>4.5/5</span>
            <small>TrustPilot Rating</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>

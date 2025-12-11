document.addEventListener('DOMContentLoaded', () => {
    // 1. Login Form Submission Handler
    const form = document.getElementById('loginForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(form);

            fetch('index.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                console.log("Raw server response:", JSON.stringify(data));
                if (data.trim() === "success") {
                    window.location.href = 'adminhome.php'; 
                } else {
                    alert("Login failed: " + data);
                }
            })
            .catch(err => {
                alert("Error: " + err);
            });
        });
    }

  // Admin Tab Switching
  const tabs = document.querySelectorAll('.tab-btn');
  const contents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      contents.forEach(c => c.classList.remove('active'));

      tab.classList.add('active');
      document.getElementById(tab.dataset.tab).classList.add('active');
    });
  });
});

// Logout function
function logout() {
  if (confirm("Log out from admin?")) {
    window.location.href = "login.html";
  }
}

// Detect device brand or platform
function detectDevice() {
  const ua = navigator.userAgent;

  if (/Windows/i.test(ua)) return "Windows PC";
  if (/Macintosh/i.test(ua)) return "MacBook / macOS";
  if (/iPhone/i.test(ua)) return "iPhone";
  if (/iPad/i.test(ua)) return "iPad";
  if (/Samsung/i.test(ua)) return "Samsung Device";
  if (/Huawei/i.test(ua)) return "Huawei Phone";
  if (/Oppo/i.test(ua)) return "OPPO Phone";
  if (/Vivo/i.test(ua)) return "Vivo Phone";
  if (/Android/i.test(ua)) return "Android Device";
  if (/Linux/i.test(ua)) return "Linux Computer";

  return "Unknown Device";
}

// Save admin login to history
function saveLoginHistory() {
  let history = JSON.parse(localStorage.getItem("loginHistory")) || [];

  // Mark any active session as logged out
  history.forEach((entry) => {
    if (entry.status === "Active") {
      entry.status = "Logged Out";
      entry.logoutTime = new Date().toLocaleString();
    }
  });

  // Create a new login record
  const newRecord = {
    user: "Admin",
    device: detectDevice(),
    loginDate: new Date().toLocaleString(),
    logoutTime: "",
    status: "Active",
  };

  history.push(newRecord);
  localStorage.setItem("loginHistory", JSON.stringify(history));
}



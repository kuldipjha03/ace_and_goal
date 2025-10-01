let selectedMonth = null;
let selectedYear = new Date().getFullYear();
document.getElementById("yearLabel").innerText = selectedYear;

function openMonthPicker() {
    document.getElementById("monthPicker").style.display = "block";
}

function closeMonthPicker() {
    document.getElementById("monthPicker").style.display = "none";
}

function changeYear(step) {
    selectedYear += step;
    document.getElementById("yearLabel").innerText = selectedYear;
}

// Month selection
document.querySelectorAll(".month").forEach(month => {
    month.addEventListener("click", () => {
        document.querySelectorAll(".month").forEach(m => m.classList.remove("active"));
        month.classList.add("active");
        selectedMonth = month.getAttribute("data-val");
    });
});

function applyMonth() {
    if (!selectedMonth) {
        alert("Please select a month!");
        return;
    }
    let dateValue = `${selectedYear}-${selectedMonth}-01`;
    document.getElementById("goal_date").value = dateValue;
    document.getElementById("monthButton").innerText =
        `${document.querySelector(".month.active").innerText} ${selectedYear}`;
    closeMonthPicker();
}

// Enable/disable KPI row inputs
function toggleRow(checkbox) {
    let row = checkbox.closest("tr");
    let selects = row.querySelectorAll("select, input[type=text]");
    selects.forEach(el => el.disabled = !checkbox.checked);
}

// Select department button
function selectDepartment(dept, btn) {
    document.getElementById("department").value = dept;
    document.getElementById("deptButton").innerText = dept;
    document.querySelectorAll(".dept-btn").forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
}

let expenses = [];
let totalAmount = 0;

const categorySelect = document.getElementById('category-select');
const amountInput = document.getElementById('amount-input');
const dateInput = document.getElementById('date-input');
const addBtn = document.getElementById('add-btn');
const expensesTableBody = document.getElementById('expnese-table-body');
const totalAmountCell = document.getElementById('total-amount');

// Load expenses from localStorage if available
if (localStorage.getItem('expenses')) {
    expenses = JSON.parse(localStorage.getItem('expenses'));
    renderExpenses();
}

// Function to render expenses
function renderExpenses() {
    totalAmount = 0;
    expensesTableBody.innerHTML = '';

    // update this renderer function to use the function filterTableData to 
    
    // update the rows in the table

    for (const expense of expenses) {
        totalAmount += expense.amount;

        const newRow = expensesTableBody.insertRow();
        const categoryCell = newRow.insertCell();
        const amountCell = newRow.insertCell();
        const dateCell = newRow.insertCell();
        const deleteCell = newRow.insertCell();
        const deleteBtn = document.createElement('button');

        deleteBtn.textContent = 'Delete';
        deleteBtn.classList.add('delete-btn');
        deleteBtn.addEventListener('click', function() {
            expenses.splice(expenses.indexOf(expense), 1);
        
        });

        categoryCell.textContent = expense.category;
        amountCell.textContent = expense.amount;
        dateCell.textContent = expense.date;
        deleteCell.appendChild(deleteBtn);
    }

    updateTotalAmount();
}

// Function to update total amount display
function updateTotalAmount() {
    totalAmountCell.textContent = totalAmount;
}

// Function to update localStorage with current expenses
function updateLocalStorage() {
    localStorage.setItem('expenses', JSON.stringify(expenses));

    //update the database with this data, make xmlhttprequest
}

// Add event listener to the 'Add' button
addBtn.addEventListener('click', function() {
    const category = categorySelect.value;
    const amount = Number(amountInput.value);
    const date = dateInput.value;

    if (category === '') {
        alert('Please select a category');
        return;
    }
    if (isNaN(amount) || amount <= 0) {
        alert('Please enter a valid amount');
        return;
    }
    if (date === '') {
        alert('Please select a date');
        return;
    }

    const expense = { category, amount, date };
    expenses.push(expense);
    uploadExpense(expense); // Call the function to upload the expense
});

function uploadExpense(expense) {
    const expenseJSON = JSON.stringify(expense);

    const xhr = new XMLHttpRequest();

    xhr.open('POST', '/upload-expense', true); 

    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            console.log('Expense uploaded successfully');
        } else {
            console.error('Failed to upload expense');
        }
    };

    xhr.send(expenseJSON);
}


function filterTableData(to,from,expense_type){
    
    //implement function that makes a call to DB using fetch API and returns collection of filtered items based on parameters to,from and 
    //expense type 

}

// Update total amount display initially
updateTotalAmount();

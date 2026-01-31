// ===== Backend API Integration Guide =====
// This file shows how to integrate the PHP backend with your frontend

const API_BASE = 'backend/api/';

// ===== AUTHENTICATION FUNCTIONS =====

async function doLoginWithBackend() {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPass').value;
    
    if (!email || !password) {
        alert('Please fill in all fields');
        return;
    }
    
    try {
        const response = await fetch(API_BASE + 'auth.php?action=login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            // Store user in localStorage
            localStorage.setItem('user', JSON.stringify(data.data));
            localStorage.setItem('isLoggedIn', 'true');
            
            alert('Login successful!');
            location.href = 'customer.html';
        } else {
            alert('Login failed: ' + data.message);
        }
    } catch (error) {
        console.error('Login error:', error);
        alert('Error during login');
    }
}

async function doRegisterWithBackend() {
    const name = document.getElementById('regName').value;
    const email = document.getElementById('regEmail').value;
    const password = document.getElementById('regPass').value;
    
    if (!name || !email || !password) {
        alert('Please fill in all fields');
        return;
    }
    
    try {
        const response = await fetch(API_BASE + 'auth.php?action=register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, password, mobile: '' })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Registration successful! Please login.');
            // Clear form
            document.getElementById('regName').value = '';
            document.getElementById('regEmail').value = '';
            document.getElementById('regPass').value = '';
        } else {
            alert('Registration failed: ' + data.message);
        }
    } catch (error) {
        console.error('Registration error:', error);
        alert('Error during registration');
    }
}

// ===== DESTINATIONS FUNCTIONS =====

async function getDestinationsFromBackend() {
    try {
        const response = await fetch(API_BASE + 'destinations.php?action=list', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            return data.data;
        } else {
            console.error('Error fetching destinations:', data.message);
            return [];
        }
    } catch (error) {
        console.error('Fetch error:', error);
        return [];
    }
}

async function addDestinationBackend(destData) {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    // Check if user is admin (you'll need to add admin flag)
    if (!user.isAdmin) {
        alert('Only admins can add destinations');
        return;
    }
    
    try {
        const response = await fetch(API_BASE + 'destinations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(destData)
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Destination added successfully!');
            return data.data;
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error adding destination');
    }
}

// ===== BOOKINGS FUNCTIONS =====

async function createBookingBackend(bookingData) {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    if (!user.id) {
        alert('Please login first');
        return;
    }
    
    bookingData.user_id = user.id;
    
    try {
        const response = await fetch(API_BASE + 'bookings.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookingData)
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Booking created successfully!');
            return data.data;
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error creating booking');
    }
}

async function getUserBookingsBackend() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    if (!user.id) {
        return [];
    }
    
    try {
        const response = await fetch(
            API_BASE + 'bookings.php?action=user&user_id=' + user.id,
            { method: 'GET' }
        );
        
        const data = await response.json();
        
        if (data.status === 'success') {
            return data.data;
        } else {
            console.error('Error fetching bookings:', data.message);
            return [];
        }
    } catch (error) {
        console.error('Fetch error:', error);
        return [];
    }
}

// ===== WISHLIST FUNCTIONS =====

async function addToWishlistBackend(destinationId) {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    if (!user.id) {
        alert('Please login first');
        return;
    }
    
    try {
        const response = await fetch(API_BASE + 'wishlist.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                user_id: user.id,
                destination_id: destinationId
            })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Added to wishlist!');
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error adding to wishlist');
    }
}

async function getWishlistBackend() {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    if (!user.id) {
        return [];
    }
    
    try {
        const response = await fetch(
            API_BASE + 'wishlist.php?user_id=' + user.id,
            { method: 'GET' }
        );
        
        const data = await response.json();
        
        if (data.status === 'success') {
            return data.data;
        } else {
            console.error('Error fetching wishlist:', data.message);
            return [];
        }
    } catch (error) {
        console.error('Fetch error:', error);
        return [];
    }
}

async function removeFromWishlistBackend(destinationId) {
    const user = JSON.parse(localStorage.getItem('user') || '{}');
    
    if (!user.id) {
        alert('Please login first');
        return;
    }
    
    try {
        const response = await fetch(
            API_BASE + 'wishlist.php?user_id=' + user.id + '&dest_id=' + destinationId,
            { method: 'DELETE' }
        );
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Removed from wishlist!');
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error removing from wishlist');
    }
}

// ===== USAGE EXAMPLES =====
/*
// In your main.js, replace the localStorage calls with these backend calls:

// Instead of:
// let state = JSON.parse(localStorage.getItem(LS)) || sampleState;

// Use:
// async function loadDestinations() {
//     const destinations = await getDestinationsFromBackend();
//     renderDestinations(destinations);
// }

// Instead of calling doLogin() directly, call:
// doLoginWithBackend()

// Instead of adding bookings to localStorage, call:
// createBookingBackend({
//     destination_id: 1,
//     check_in: '2026-02-01',
//     check_out: '2026-02-05',
//     travelers: 2,
//     total_price: 36000
// })
*/

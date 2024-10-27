const appetizers = [
    { name: "Bruschetta", price: "$8.00", img: "https://via.placeholder.com/50" },
    { name: "Calamari Fritti", price: "$12.00", img: "https://via.placeholder.com/50" },
    { name: "Antipasto Platter", price: "$15.00", img: "https://via.placeholder.com/50" },
    { name: "Stuffed Mushrooms", price: "$10.00", img: "https://via.placeholder.com/50" },
    { name: "Caprese Salad", price: "$9.00", img: "https://via.placeholder.com/50" },
    { name: "Garlic Bread", price: "$5.00", img: "https://via.placeholder.com/50" },
    { name: "Shrimp Cocktail", price: "$14.00", img: "https://via.placeholder.com/50" },
    { name: "Pâté de Campagne", price: "$11.00", img: "https://via.placeholder.com/50" },
    { name: "Cheese Board", price: "$16.00", img: "https://via.placeholder.com/50" },
    { name: "Vegetable Spring Rolls", price: "$7.00", img: "https://via.placeholder.com/50" }
];

const mainCourses = [
    { name: "Osso Buco", price: "$28.00", img: "https://via.placeholder.com/50" },
    { name: "Ribeye Steak", price: "$32.00", img: "https://via.placeholder.com/50" },
    { name: "Seafood Risotto", price: "$25.00", img: "https://via.placeholder.com/50" },
    { name: "Vegetable Lasagna", price: "$20.00", img: "https://via.placeholder.com/50" },
    { name: "Chicken Piccata", price: "$22.00", img: "https://via.placeholder.com/50" },
    { name: "Pork Tenderloin", price: "$26.00", img: "https://via.placeholder.com/50" },
    { name: "Lamb Chops", price: "$30.00", img: "https://via.placeholder.com/50" },
    { name: "Pasta Primavera", price: "$18.00", img: "https://via.placeholder.com/50" },
    { name: "Duck Confit", price: "$35.00", img: "https://via.placeholder.com/50" },
    { name: "Grilled Salmon", price: "$27.00", img: "https://via.placeholder.com/50" }
];

const desserts = [
    { name: "Tiramisu", price: "$7.00", img: "https://via.placeholder.com/50" },
    { name: "Crème Brûlée", price: "$8.00", img: "https://via.placeholder.com/50" },
    { name: "Panna Cotta", price: "$7.50", img: "https://via.placeholder.com/50" },
    { name: "Chocolate Fondant", price: "$9.00", img: "https://via.placeholder.com/50" },
    { name: "Apple Tart", price: "$6.00", img: "https://via.placeholder.com/50" },
    { name: "Cheesecake", price: "$7.00", img: "https://via.placeholder.com/50" },
    { name: "Profiteroles", price: "$8.50", img: "https://via.placeholder.com/50" },
    { name: "Berry Sorbet", price: "$6.50", img: "https://via.placeholder.com/50" },
    { name: "Flan", price: "$5.00", img: "https://via.placeholder.com/50" },
    { name: "Baklava", price: "$8.00", img: "https://via.placeholder.com/50" }
];

const beverages = [
    { name: "Rượu vang đỏ", price: "$10.00", img: "https://via.placeholder.com/50" },
    { name: "Nước khoáng", price: "$5.00", img: "https://via.placeholder.com/50" },
    { name: "Cà phê Espresso", price: "$3.00", img: "https://via.placeholder.com/50" },
    { name: "Trà nóng", price: "$2.50", img: "https://via.placeholder.com/50" },
    { name: "Rượu vang trắng", price: "$10.00", img: "https://via.placeholder.com/50" },
    { name: "Cocktail Mojito", price: "$12.00", img: "https://via.placeholder.com/50" },
    { name: "Soda", price: "$2.00", img: "https://via.placeholder.com/50" },
    { name: "Nước trái cây", price: "$4.00", img: "https://via.placeholder.com/50" },
    { name: "Cacao nóng", price: "$3.50", img: "https://via.placeholder.com/50" },
    { name: "Sữa tươi", price: "$2.50", img: "https://via.placeholder.com/50" }
];

function populateMenu(category, items) {
    const ul = document.getElementById(category);
    items.forEach(item => {
        const li = document.createElement('li');
        
        // Tạo container cho hình ảnh
        const imgContainer = document.createElement('div');
        imgContainer.classList.add('img-container');
        const img = document.createElement('img');
        img.src = item.img;
        img.alt = item.name;
        imgContainer.appendChild(img);
        
        li.appendChild(imgContainer);
        li.appendChild(document.createTextNode(item.name + ' '));
        const priceSpan = document.createElement('span');
        priceSpan.classList.add('price');
        priceSpan.textContent = item.price;
        li.appendChild(priceSpan);
        ul.appendChild(li);
    });
}

populateMenu('appetizers', appetizers);
populateMenu('main-courses', mainCourses);
populateMenu('desserts', desserts);
populateMenu('beverages', beverages);

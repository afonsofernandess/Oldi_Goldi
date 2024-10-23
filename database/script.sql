
    DROP TABLE IF EXISTS Users;
    CREATE TABLE Users (
        username TEXT PRIMARY KEY,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone_number TEXT,
        password TEXT NOT NULL,
        photo_url TEXT DEFAULT 'https://storage.googleapis.com/flutterflow-io-6f20.appspot.com/projects/uni-connect-4nugh7/assets/rpm3muv6rtc6/user_default.jpg',
        Country TEXT,
        Adress TEXT,
        Zip_code TEXT,
        Cidade TEXT,
        description TEXT,
        isAdmin BOOLEAN NOT NULL DEFAULT false,
        isSeller BOOLEAN NOT NULL DEFAULT false


    );

    DROP TABLE IF EXISTS Categories;
    CREATE TABLE Categories (
        category_id INTEGER PRIMARY KEY,
        category_name TEXT UNIQUE NOT NULL
    );

    DROP TABLE IF EXISTS Sizes;
    CREATE TABLE Sizes (
        size_id INTEGER PRIMARY KEY,
        size_value TEXT UNIQUE NOT NULL
    );

    DROP TABLE IF EXISTS Brands;
    CREATE TABLE Brands (
        brand_id INTEGER PRIMARY KEY,
        brand_name TEXT NOT NULL
    );

    DROP TABLE IF EXISTS Conditions;
    CREATE TABLE Conditions (
        condition_id INTEGER PRIMARY KEY,
        condition_value TEXT UNIQUE NOT NULL
    );

    DROP TABLE IF EXISTS Item;
    CREATE TABLE Item (
        ItemID NUMERIC CONSTRAINT ITEM_PK PRIMARY KEY NOT NULL,
        model TEXT NOT NULL,
        item_name TEXT NOT NULL,
        description TEXT,
        price NUMERIC NOT NULL,
        seller NUMERIC NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
        size_id NUMERIC REFERENCES Sizes(SizeID) ON DELETE CASCADE,
        condition_id NUMERIC NOT NULL REFERENCES Conditions(condition_id) ON DELETE CASCADE,
        category_id NUMERIC NOT NULL REFERENCES Categories(category_id) ON DELETE CASCADE,
        transaction_id NUMERIC REFERENCES Transactions(transaction_id) ON DELETE CASCADE,
        shopping_cart_id NUMERIC REFERENCES ShoppingCarts(shopping_cart_id) ON DELETE CASCADE,
        brand_id NUMERIC REFERENCES Brands(brand_id) ON DELETE CASCADE,
        is_sold BOOLEAN NOT NULL DEFAULT false
    );

    DROP TABLE IF EXISTS Transactions;
    CREATE TABLE Transactions (
        transaction_id INTEGER PRIMARY KEY,
        buyer INTEGER NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
        seller INTEGER NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
        item_id INTEGER NOT NULL REFERENCES Item(ItemID) ON DELETE CASCADE,
        total_value NUMERIC NOT NULL,
        transaction_date TEXT NOT NULL,
        card_id INTEGER NOT NULL REFERENCES Cards(card_id) ON DELETE CASCADE
    );



    DROP TABLE IF EXISTS Whishlists;
    CREATE TABLE Whishlists (

        item_id NUMERIC NOT NULL,
        username INTEGER NOT NULL,
        PRIMARY KEY (item_id, username)
    );
    
    DROP TABLE IF EXISTS Photos;
    CREATE TABLE Photos (
        photo_id INTEGER PRIMARY KEY,
        photo_url TEXT NOT NULL,
        item_id INTEGER NOT NULL REFERENCES Item(ItemID) ON DELETE CASCADE
    );

    DROP TABLE IF EXISTS chats;
    CREATE TABLE chats (
    chat_id INTEGER PRIMARY KEY,
    seller INTEGER NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
    buyer INTEGER NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
    item_id INTEGER NOT NULL REFERENCES Item(ItemID) ON DELETE CASCADE
    );

    DROP TABLE IF EXISTS messages;
    CREATE TABLE messages (
    message_id INTEGER NOT NULL PRIMARY KEY,
    chat_id INTEGER NOT NULL REFERENCES chats(chat_id) ON DELETE CASCADE,
    sender_id INTEGER NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
    message TEXT NOT NULL,
    timestamp TIMESTAMP,
    is_price_proposal BOOLEAN NOT NULL DEFAULT false,
    price_proposal NUMERIC
    );

    DROP TABLE IF EXISTS UserPrices;
    CREATE TABLE UserPrices (
    userPrice_id INTEGER PRIMARY KEY,
    username INTEGER NOT NULL,
    ItemID INTEGER NOT NULL,
    proposed_price REAL NOT NULL,
    FOREIGN KEY(username) REFERENCES Users(username),
    FOREIGN KEY(ItemID) REFERENCES Items(ItemID)
    );

    DROP TABLE IF EXISTS Cards;
    CREATE TABLE Cards (
    card_id INTEGER PRIMARY KEY,
    card_number TEXT NOT NULL,
    card_name TEXT NOT NULL,
    username TEXT NOT NULL REFERENCES Users(username) ON DELETE CASCADE,
    expiration_date TEXT NOT NULL,
    cvv TEXT NOT NULL
    );

    INSERT INTO Users (username, name, email, phone_number, password, photo_url, Country, Adress, Zip_code, Cidade, description, isAdmin, isSeller) 
VALUES 
('john_doe', 'John Doe', 'johndoe99@gmail.com', '+1234567890', 'password123', 'https://pbs.twimg.com/media/FjU2lkcWYAgNG6d.jpg', 'USA', '123 Main St', '12345', 'New York', 'I love hiking and photography', false, true),
('jane_smith', 'Jane Smith', 'janeS@gmail.com', '+1987654321', 'qwerty456', 'https://c.stocksy.com/a/UMV200/z9/597214.jpg', 'Canada', '456 Maple Ave', '56789', 'Toronto', 'Passionate about cooking and travel', false, false),
('sam_jones', 'Sam Jones', 'samDarlean@gmail.com', '+1122334455', 'samspassword', 'https://images.ctfassets.net/h6goo9gw1hh6/2sNZtFAWOdP1lmQ33VwRN3/24e953b920a9cd0ff2e1d587742a2472/1-intro-photo-final.jpg?w=1200&h=992&fl=progressive&q=70&fm=jpg', 'UK', '789 Oak St', '67890', 'London', 'Tech enthusiast and gamer', false, true),
('lisa_white', 'Lisa White', 'lisawhite22@gmail.com', '+4433221100', 'lisapass', 'https://www.perfocal.com/blog/content/images/size/w960/2021/01/Perfocal_17-11-2019_TYWFAQ_100_standard-3.jpg', 'Australia', '101 Palm St', '45678', 'Sydney', 'Fitness freak and nature lover', false, true),
('mike_brown', 'Mike Brown', 'MikeJsonB23@gmail.com', '+1555098765', 'mikepass123', 'https://i.pinimg.com/474x/98/51/1e/98511ee98a1930b8938e42caf0904d2d.jpg', 'Germany', '321 Elm St', '23456', 'Berlin', 'Musician and coffee addict', false, true),
('sara_green', 'Sara Green', 'saraGree12@gmail.com', '+6667778889', 'green123', 'https://newprofilepic.photo-cdn.net//assets/images/article/profile.jpg?90af0c8', 'France', '543 Birch St', '34567', 'Paris', 'Art enthusiast and traveler', false, true),
('chris_taylor', 'Chris Taylor', 'chris@example.com', '+9876543210', 'taylorpass', 'https://storage.needpix.com/rsynced_images/man-profile-1105761_1280.jpg', 'Brazil', '876 Pine St', '78901', 'Rio de Janeiro', 'Surfer and beach lover', false, true),
('emily_clark', 'Emily Clark', 'emily02@gmail.com', '+1122334455', 'clarkpass', 'https://cdn.pixabay.com/photo/2021/02/27/16/25/woman-6055084_1280.jpg', 'Japan', '234 Cedar St', '34567', 'Tokyo', 'Anime fan and foodie', false, true),
('adam_wilson', 'Adam Wilson', 'adamWili@gmail.com', '+1555098765', 'wilson123', 'https://www.mensjournal.com/.image/t_share/MTk2MTM2NTcwNDMxMjg0NzQx/man-taking-selfie.jpg', 'Spain', '567 Walnut St', '90123', 'Madrid', 'History buff and language learner', false, true),
('olivia_tan', 'Olivia Tan', 'oliviaTan44@gmail.com.com', '+6667778889', 'tanpass', 'https://external-preview.redd.it/half-profile-portrait-of-a-young-22-year-old-woman-with-few-v0-0oEj7tQYK6jLKd6dZBL6Nvm6fUyAJbhoLgWBMMnn4TU.jpg?auto=webp&s=77a66a0c543ae960b220fed4660efb4a1de8f98d', 'China', '890 Oak St', '23456', 'Beijing', 'Fashion designer and cat lover', false, true),
('Admin', 'Admin', 'admin@gmail.com',NULL,'$2y$10$ZSqn3boB4wu53QPj/Ffw0uX6IZ0ef6kWpSTug5rPrIZqV5bgHu19u','https://storage.googleapis.com/flutterflow-io-6f20.appspot.com/projects/uni-connect-4nugh7/assets/rpm3muv6rtc6/user_default.jpg',NULL,NULL,NULL,NULL,NULL,true,false);


-- Categories
INSERT INTO Categories (category_id, category_name) 
VALUES 
(1, 'Clothing'),
(2, 'Electronics'),
(3, 'Books'),
(4, 'Home & Garden'),
(5, 'Sports'),
(6, 'Toys'),
(7, 'Health & Beauty'),
(8, 'Automotive'),
(9, 'Jewelry'),
(10, 'Food & Beverages');


-- Sizes
INSERT INTO Sizes (size_id, size_value) 
VALUES 
(1, 'Small'),
(2, 'Medium'),
(3, 'Large'),
(4, 'XL'),
(5, 'XXL'),
(6, '30'),
(7, '31'),
(8, '32'),
(9, '33'),
(10, '34'),
(11, '35'),
(12, '36'),
(13, '37'),
(14, '38'),
(15, '39'),
(16, '40'),
(17, '41'),
(18, '42'),
(19, '43'),
(20, '44'),
(21, '45');


-- Brands
INSERT INTO Brands (brand_id, brand_name) 
VALUES 
(1, 'Nike'),
(2, 'Apple'),
(3, 'Samsung'),
(4, 'IKEA'),
(5, 'Adidas'),
(6, 'Sony'),
(7, 'Cannon'),
(8, 'Microsoft'),
(9, 'Rolex'),
(10, 'Ralph Lauren'),
(11, 'Zara'),
(12, 'H&M'),
(13, 'Uniqlo'),
(14, 'Gap'),
(15, 'Fred Perry'),
(16, 'Levis'),
(17, 'Tommy Hilfiger'),
(18, 'Calvin Klein'),
(19, 'Mango'),
(20, 'Prada'),
(21, 'Shein'),
(22, 'Louis Vuitton'),
(23, 'Stradivarius'),
(24, 'Bershka'),
(25, 'Pull&Bear');


-- Conditions
INSERT INTO Conditions (condition_id, condition_value) 
VALUES 
(1, 'New'),
(2, 'Used - Like New'),
(3, 'Used - Good'),
(4, 'Used - Fair'),
(5, 'Refurbished');

-- Item
INSERT INTO Item (ItemID, model, item_name, description, price, seller, size_id, condition_id, category_id, brand_id,is_sold) VALUES
(1, 'Air Max', 'Nike Air Max', 'Used Nike Air Max shoes', 50, 'john_doe', 18, 1, 5, 1,0),
(2, 'iPhone 12', 'Apple iPhone 12', 'Used Apple iPhone 12', 600, 'sara_green', NULL, 1, 2, 2,0),
(3, 'Galaxy S21', 'Samsung Galaxy S21', 'Used Samsung Galaxy S21', 500, 'sara_green', NULL, 1, 2, 3,0),
(4, 'Billy Bookcase', 'IKEA Billy Bookcase', 'Used IKEA Billy Bookcase', 30, 'john_doe', NULL, 1, 3, 4,0),
(5, 'Ultraboost', 'Adidas Ultraboost', 'Used Adidas Ultraboost shoes', 60, 'mike_brown', 16, 1, 5, 5,0),
(6, 'PlayStation 5', 'Sony PlayStation 5', 'Used Sony PlayStation 5', 400, 'mike_brown', NULL, 1, 2, 6,0),
(7, 'EOS 5D', 'Canon EOS 5D', 'Used Canon EOS 5D camera', 800, 'sam_jones', NULL, 1, 2, 7,0),
(8, 'Surface Pro', 'Microsoft Surface Pro', 'Used Microsoft Surface Pro', 700, 'john_doe', NULL, 1, 2, 8,1),
(9, 'Submariner', 'Rolex Submariner', 'Used Rolex Submariner watch', 5000, 'mike_brown', NULL, 1, 4, 9,0),
(10, 'Polo Shirt', 'Ralph Lauren Polo Shirt', 'Used Ralph Lauren Polo Shirt', 30, 'olivia_tan', 3, 1, 1, 10,0),
(11, 'Basic T-Shirt', 'Zara Basic T-Shirt', 'Used Zara Basic T-Shirt', 10, 'lisa_white', 4, 1, 1, 11,0),
(12, 'Slim Fit Jeans', 'H&M Slim Fit Jeans', 'Used H&M Slim Fit Jeans', 20, 'olivia_tan', 10, 1, 1, 12,0),
(13, 'U Crew Neck T-Shirt', 'Uniqlo U Crew Neck T-Shirt', 'Used Uniqlo U Crew Neck T-Shirt', 10, 'lisa_white', 2, 1, 1, 13,0),
(14, 'Logo Hoodie', 'Gap Logo Hoodie', 'Used Gap Logo Hoodie', 25, 'emily_clark', 3, 1, 1, 14,0),
(15, 'Twin Tipped Polo', 'Fred Perry Twin Tipped Polo', 'Used Fred Perry Twin Tipped Polo', 40, 'john_doe', 2, 1, 1, 15,0),
(16, '501 Original Fit Jeans', 'Levis 501 Original Fit Jeans', 'Used Levis 501 Original Fit Jeans', 30, 'lisa_white', 10, 1, 1, 16,0),
(17, 'Logo T-Shirt', 'Tommy Hilfiger Logo T-Shirt', 'Used Tommy Hilfiger Logo T-Shirt', 20, 'emily_clark', 1, 1, 1, 17,0),
(18, 'Logo Briefs', 'Calvin Klein T-Shirt', 'Used Calvin Klein T-Shirt', 10, 'adam_wilson', 2, 1, 1, 18,0),
(19, 'Slim Fit Chinos', 'Mango Slim Fit Chinos', 'Used Mango Slim Fit Chinos', 20, 'olivia_tan', 5, 1, 1, 19,1),
(20, 'Logo T-Shirt', 'Prada Logo T-Shirt', 'Used Prada Logo T-Shirt', 100, 'adam_wilson', 2, 1, 1, 20,0),
(21, 'Floral Dress', 'Shein Floral Dress', 'Used Shein Floral Dress', 15, 'sam_jones', 3, 1, 1, 21,0),
(22, 'Logo Belt', 'Louis Vuitton Logo Belt', 'Used Louis Vuitton Logo Belt', 200, 'olivia_tan', NULL, 1, 10, 22,1),
(23, 'Floral Blouse', 'Stradivarius Floral Blouse', 'Used Stradivarius Floral Blouse', 15, 'john_doe', 4, 1, 1, 23,1),
(24, 'Skinny Jeans', 'Bershka Skinny Jeans', 'Used Bershka Skinny Jeans', 20, 'sara_green', 16, 1, 1, 24,1),
(25, 'Logo T-Shirt', 'Pull&Bear Logo T-Shirt', 'Used Pull&Bear Logo T-Shirt', 10, 'sara_green', 2, 1, 1, 25,0);



-- Photos
INSERT INTO Photos (photo_id, photo_url, item_id) 
VALUES 
(1,'../images/AirMax.png',1),
(2, '../images/Iphone12.jpg', 2),
(3, '../images/S21.png', 3),
(4, '../images/BookCase.jpg', 4),
(5,'../images/AdidasUB.png',5),
(6, '../images/PS5.png', 6),
(7, '../images/CANON.jpeg', 7),
(8, '../images/SURF.jpg', 8),
(9, '../images/Rolex.jpg', 9),
(10, '../images/RL.jpg', 10),
(11, '../images/zara.jpg', 11),
(12, '../images/HMJeans.jpg', 12),
(13, '../images/Uni.jpg', 13),
(14, '../images/Gap.jpg', 14),
(15, '../images/FredP.jpg', 15),
(16, '../images/Levis.jpg', 16),
(17, '../images/Tommy.jpg', 17),
(18, '../images/CK.jpg', 18),
(19, '../images/Mango.jpg', 19),
(20, '../images/Prada.jpg', 20),
(21, '../images/Shein.jpeg', 21),
(22, '../images/LV.jpg', 22),
(23, '../images/Stradi.jpg', 23),
(24, '../images/Breska.jpg', 24),
(25, '../images/PB.jpg', 25);


INSERT INTO Transactions (transaction_id, buyer, seller, item_id, total_value, transaction_date, card_id) 
VALUES
(1, 'adam_wilson', 'john_doe', 23, 15, '2022-01-01', 1),
(2, 'lisa_white', 'john_doe', 8, 700, '2022-01-02', 2),
(3, 'chris_taylor', 'sara_green', 24, 20, '2022-01-03', 3),
(4, 'lisa_white', 'olivia_tan', 19, 20, '2022-01-04', 4),
(5, 'adam_wilson', 'olivia_tan', 22, 200, '2022-01-05', 5);

INSERT INTO Whishlists (item_id, username) 
VALUES
(6, 'lisa_white'),
(2, 'olivia_tan'),
(3, 'chris_taylor'),
(7, 'chris_taylor'),
(5, 'mike_brown');

INSERT INTO Cards (card_id, card_number, card_name, username, expiration_date, cvv) VALUES
(1, '4111111111111111', 'Adam Wilson', 'adam_wilson', '2024-12-31', '123'),
(2, '5222222222222222', 'Lisa White', 'lisa_white', '2025-01-31', '234'),
(3, '6333333333333333', 'Chris Taylor', 'chris_taylor', '2023-11-30', '345'),
(4, '7444444444444444', 'Lisa White', 'lisa_white', '2026-10-31', '456'),
(5, '8555555555555555', 'Adam Wilson', 'adam_wilson', '2022-09-30', '567');

-- Populate users
INSERT INTO users (email, username, name, password, birth_date, credit_balance, is_admin, state, rating) VALUES
('john.doe@example.com', 'johndoe', 'John Doe', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1990-01-01', 50000, FALSE, 'Active', 4),
('jane.smith@example.com', 'janesmith', 'Jane Smith', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1985-05-15', 50000, FALSE, 'Active', 5),
('deleted.user@example.com', 'deleteduser', 'Deleted User', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1975-08-22', 50000, FALSE, 'Deleted', 1),
('alice.johnson@example.com', 'alicej', 'Alice Johnson', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1992-03-20', 75500, FALSE, 'Active', 3),
('bob.wilson@example.com', 'bobw', 'Bob Wilson', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1988-11-12', 50000, FALSE, 'Active', 4),
('carol.taylor@example.com', 'carolt', 'Carol Taylor', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1995-07-30', 50000, FALSE, 'Active', 2),
('david.brown@example.com', 'davidb', 'David Brown', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1982-09-05', 50000, FALSE, 'Active', 5),
('emma.davis@example.com', 'emmad', 'Emma Davis', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1993-12-18', 50000, FALSE, 'Active', 4),
('frank.miller@example.com', 'frankm', 'Frank Miller', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1987-06-25', 95000, FALSE, 'Active', 3),
('grace.lee@example.com', 'gracel', 'Grace Lee', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1991-04-30', 60000, FALSE, 'Active', 5),
('henry.wang@example.com', 'henryw', 'Henry Wang', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1989-02-14', 100100, FALSE, 'Active', 4),
('isabel.garcia@example.com', 'isabelg', 'Isabel Garcia', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjaac13272958f4277febfc681e3  0.0s
 => => exporting attestation manifest sha256:0718088ac0fd2215b7a4brngQvS3Z.65fxW/aYy8Yq', '1994-09-08', 70000, FALSE, 'Active', 3),
('jack.robinson@example.com', 'jackr', 'Jack Robinson', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1986-11-30', 85000, FALSE, 'Active', 5),
('karen.white@example.com', 'karenw', 'Karen White', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1993-07-22', 40000, FALSE, 'Active', 2),
('liam.taylor@example.com', 'liamt', 'Liam Taylor', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1990-12-05', 130000, FALSE, 'Active', 4),
('mia.anderson@example.com', 'miaa', 'Mia Anderson', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1988-04-17', 90000, FALSE, 'Active', 3),
('nathan.clark@example.com', 'nathanc', 'Nathan Clark', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1991-10-10', 50050, FALSE, 'Active', 4),
('olivia.martinez@example.com', 'oliviam', 'Olivia Martinez', '$2y$10$RTQg99nD/kjmAI7b6l187.FLnoVh3uAT/m87ERCu0tT3TkgThesFm', '1987-03-25', 105000, FALSE, 'Active', 5),
('peter.brown@example.com', 'peterb', 'Peter Brown', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1994-01-20', 65000, FALSE, 'Active', 3),
('quinn.foster@example.com', 'quinnf', 'Quinn Foster', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq', '1989-08-08', 75000, FALSE, 'Active', 4),
('admin@lbaw24.com', 'admin', 'Admin', '$2y$10$sUY.kxsoyTrNZwLh6zrJn.HQ1ckKdnjbrngQvS3Z.65fxW/aYy8Yq','1989-04-10', 0, TRUE, 'Active', NULL),
('lbaw@lbaw.com','lbaw','lbaw','$2y$10$RTQg99nD/kjmAI7b6l187.FLnoVh3uAT/m87ERCu0tT3TkgThesFm','1980-04-10',1000000,FALSE,'Active',1);


-- Populate addresses
INSERT INTO address (street, city, district, zip_code, country, user_id) VALUES
('123 Main St', 'City A', 'District A', '12345', 'Country X', 1),
('456 Maple Ave', 'City B', 'District B', '67890', 'Country Y', 2),
('789 Oak Rd', 'City C', 'District C', '13579', 'Country Z', 3),
('101 Pine Lane', 'City D', 'District D', '24680', 'Country W', 4),
('202 Cedar St', 'City E', 'District E', '97531', 'Country V', 5),
('303 Birch Ave', 'City F', 'District F', '86420', 'Country U', 6),
('404 Elm Rd', 'City G', 'District G', '75319', 'Country T', 7),
('505 Willow St', 'City H', 'District H', '13579', 'Country S', 8),
('606 Ash Lane', 'City I', 'District I', '24680', 'Country R', 9),
('707 Poplar Rd', 'City J', 'District J', '97531', 'Country Q', 10),
('808 Cherry Blvd', 'City K', 'District K', '35791', 'Country P', 11),
('909 Walnut St', 'City L', 'District L', '86420', 'Country O', 12),
('1010 Spruce Ave', 'City M', 'District M', '24680', 'Country N', 13),
('1111 Fir Lane', 'City N', 'District N', '97531', 'Country M', 14),
('1212 Redwood Rd', 'City O', 'District O', '13579', 'Country L', 15),
('1313 Sequoia St', 'City P', 'District P', '86420', 'Country K', 16),
('1414 Sycamore Ave', 'City Q', 'District Q', '24680', 'Country J', 17),
('1515 Chestnut Rd', 'City R', 'District R', '97531', 'Country I', 18),
('1616 Beech Lane', 'City S', 'District S', '13579', 'Country H', 19),
('1717 Magnolia Blvd', 'City T', 'District T', '86420', 'Country G', 20);

-- Populate Categories
INSERT INTO category (name) VALUES
('Watches'), ('Vehicles'), ('Jewelry'), ('Collectibles'), ('Sports Memorabilia'),
('Art'), ('Antiques'), ('Coins & Paper Money'), ('Electronics');

-- Populate Auctions
INSERT INTO auction (title, description, start_price, current_bid, start_date, end_date, state, owner_id, category_id) VALUES
('Vintage Car Auction', 'Auction for a vintage car', 5000, NULL, '2024-10-30 10:00:00', '2024-12-20 04:52:10', 'Ongoing', 1,1),
('Antique Painting Auction', 'Rare antique painting', 2000, NULL, '2024-10-15 12:00:00', NULL, 'Closed', 2,1),
('Rare Comic Book Collection', 'Collection of rare comic books', 3000, NULL, '2024-10-20 09:00:00', NULL, 'Closed', 4,1),
('Diamond Necklace', 'Exquisite diamond necklace', 10000, NULL, '2024-10-25 14:00:00', NULL, 'Closed', 5,1),
('Signed Football Jersey', 'Jersey signed by famous player', 1500, NULL, '2024-11-01 11:00:00', NULL, 'Closed', 6,1),
('Antique Clock', 'Rare antique grandfather clock', 4000, NULL, '2024-11-05 13:00:00', NULL, 'Closed', 7,1),
('Vintage Camera', 'Classic film camera from the 1960s', 1200, NULL, '2024-11-10 10:00:00', NULL, 'Closed', 8,1),
('First Edition Book', 'Rare first edition of a classic novel', 2500, NULL, '2024-11-15 15:00:00', NULL, 'Ongoing', 9,1),
('Designer Handbag', 'Limited edition designer handbag', 3500, NULL, '2024-11-20 12:00:00', NULL, 'Ongoing', 10,1),
('Vintage Record Player', 'Fully restored vintage record player', 1800, NULL, '2024-11-25 14:00:00', NULL, 'Ongoing', 1,1),
('Rare Stamp Collection', 'Comprehensive collection of rare stamps', 7500, NULL, '2024-12-01 09:00:00', NULL, 'Ongoing', 11,1),
('Antique Furniture Set', 'Complete set of Victorian-era furniture', 15000, NULL, '2024-12-05 11:00:00', NULL, 'Ongoing', 12,1),
('Vintage Guitar', 'Rare 1950s electric guitar', 8000, NULL, '2024-12-10 10:30:00', NULL, 'Ongoing', 13,1),
('Rare Coin Collection', 'Collection of ancient and rare coins', 12000, NULL, '2024-12-15 13:00:00', NULL, 'Ongoing', 14,1),
('Antique Pocket Watch', 'Gold pocket watch from the 1800s', 3500, NULL, '2024-12-20 14:30:00', NULL, 'Ongoing', 15,1),
('Vintage Movie Poster Collection', 'Collection of classic movie posters', 2000, NULL, '2024-12-25 12:00:00', NULL, 'Ongoing', 16,1),
('Rare Vinyl Records', 'Collection of rare and first press vinyl records', 5000, NULL, '2024-12-30 11:00:00', NULL, 'Ongoing', 17,1),
('Antique Tea Set', 'Complete antique porcelain tea set', 1800, NULL, '2025-01-05 10:00:00', NULL, 'Ongoing', 18,1),
('Vintage Typewriter', 'Fully functional vintage typewriter', 1000, NULL, '2025-01-10 15:00:00', NULL, 'Ongoing', 19,1),
('Antique Map Collection', 'Collection of rare antique maps', 9000, NULL, '2025-01-15 14:00:00', NULL, 'Ongoing', 20,1);

-- Populate user image

INSERT INTO user_image (path, user_id)
VALUES 
('/images/user1_profile.jpg', 1),
('/images/user2_profile.jpg', 2),
('/images/user3_profile.jpg', 3);

-- Populate auction Images 
INSERT INTO auction_image (path, auction_id) VALUES
('vintage_car.jpg', 1),
('antique_painting.jpg', 2),
('comic_books.jpg', 3),
('diamond_necklace.jpg', 4),
('football_jersey.jpg', 5),
('antique_clock.jpg', 6),
('designer_handbag.jpg', 9),
('vintage_record_player.jpg', 10),
('first_edition_book.jpg', 7),
('limited_edition_sneakers.jpg', 8),
('rare_stamps.jpg', 11),
('antique_furniture.jpg', 12),
('vintage_guitar.jpg', 13),
('rare_coins.jpg', 14),
('antique_pocket_watch.jpg', 15),
('vintage_movie_posters.jpg', 16),
('rare_vinyl_records.jpg', 17),
('antique_tea_set.jpg', 18),
('vintage_typewriter.jpg', 19),
('antique_maps.jpg', 20);

INSERT INTO follows_auction (user_id, auction_id) VALUES
(1,11),
(1,19),
(2,6);

-- Populate bids
INSERT INTO bid (amount, bid_date, auction_id, user_id) VALUES
--(5500, '2024-10-10 10:30:00', 1, 2),
(2200, '2024-10-16 13:00:00', 2, 1),
(3200, '2024-10-21 10:15:00', 3, 5),
(10500, '2024-10-26 15:30:00', 4, 6),
(1600, '2024-11-02 12:45:00', 5, 4),
(4100, '2024-11-06 14:20:00', 6, 2),
(1300, '2024-11-11 11:30:00', 7, 4),
(2600, '2024-11-16 16:15:00', 8, 7),
(3600, '2024-11-21 13:00:00', 9, 9),
(7800, '2024-12-02 10:00:00', 11, 12),
(15500, '2024-12-06 12:30:00', 12, 14),
(8200, '2024-12-11 11:45:00', 13, 16),
(12500, '2024-12-16 14:15:00', 14, 18),
(3700, '2024-12-21 15:30:00', 15, 20),
(2100, '2024-12-26 13:00:00', 16, 2),
(5200, '2024-12-31 12:15:00', 17, 13),
(1900, '2025-01-06 11:30:00', 18, 15),
(1100, '2025-01-11 16:00:00', 19, 17),
(9300, '2025-01-16 15:15:00', 20, 19),
(5200, '2024-12-11 15:15:00', 1, 22);

-- Populate Reports
INSERT INTO report (description, view_status, state, user_id, auction_id) VALUES
('This auction is fraudulent.', FALSE, 'Pending', 1, 4),
('Inappropriate content in auction description.', FALSE, 'Pending', 3, 1),
('Suspected shill bidding on this auction.', FALSE, 'Pending', 5, 1),
('Item does not match the description.', FALSE, 'Pending', 6, 2),
('User is not responding to messages.', FALSE, 'Pending', 2, 4),
('Auction ended prematurely.', FALSE, 'Pending', 4, 10),
('Counterfeit item being sold.', FALSE, 'Pending', 7, 1),
('Seller has multiple accounts.', FALSE, 'Pending', 9, 12),
('Bidding seems suspicious.', FALSE, 'Pending', 11, 17),
('Auction description is misleading.', FALSE, 'Pending', 13, 1),
('Item condition not as described.', FALSE, 'Pending', 15, 1),
('Seller is not honoring the winning bid.', FALSE, 'Pending', 17, 1),
('Possible copyright infringement in auction.', FALSE, 'Pending', 19, 1),
('Seller has negative feedback but continues to list items.', FALSE, 'Pending', 10, 2),
('Auction price seems artificially inflated.', FALSE, 'Pending', 12, 2),
('Suspected use of fake bids to drive up price.', FALSE, 'Pending', 14, 2);

-- Populate Auction Winners
INSERT INTO auction_winner (auction_id, user_id, rating) VALUES
--(1, 2, 5), 
(3, 5, 4),
(5, 4, 5),
(7, 4, 4),
(9, 9, 5),
(11, 12, 4);

-- Populate Notifications
INSERT INTO notification (content, notification_date, type, view_status, user_id, bid_id) VALUES
('You have been outbid on Auction 1.', '2024-10-10 10:35:00', 'BidUpdate', FALSE, 1, 1),
('Auction 1 is ending soon.', '2024-11-09 12:00:00', 'AuctionUpdate', FALSE, 2, 1),
('Your bid was successful on Auction 3.', '2024-10-21 10:16:00', 'BidUpdate', FALSE, 5, 3),
('New auction in your favorite category: Jewelry', '2024-10-25 14:05:00', 'AuctionUpdate', FALSE, 4, 4),
('You won Auction 5!', '2024-12-01 11:01:00', 'AuctionUpdate', FALSE, 4, 5),
('Your auction "Antique Clock" has a new bid.', '2024-11-06 14:21:00', 'BidUpdate', FALSE, 7, 6),
('New auction in Electronics category.', '2024-11-10 10:05:00', 'AuctionUpdate', FALSE, 3, 7),
('Your bid on "First Edition Book" was outbid.', '2024-11-16 16:20:00', 'BidUpdate', FALSE, 6, 8),
('Auction "Designer Handbag" is ending in 24 hours.', '2024-12-19 12:00:00', 'AuctionUpdate', FALSE, 10, 9),
('You have been outbid on Auction 11.', '2024-12-02 10:05:00', 'BidUpdate', FALSE, 11, 11),
('Auction 12 is ending soon.', '2025-01-04 11:00:00', 'AuctionUpdate', FALSE, 12, 12),
('Your bid was successful on Auction 13.', '2024-12-11 11:46:00', 'BidUpdate', FALSE, 16, 13),
('New auction in your favorite category: Coins', '2024-12-15 13:05:00', 'AuctionUpdate', FALSE, 14, 14),
('You won Auction 15!', '2025-01-20 14:31:00', 'AuctionUpdate', FALSE, 20, 15),
('Your auction "Vintage Movie Poster Collection" has a new bid.', '2024-12-26 13:01:00', 'BidUpdate', FALSE, 16, 16),
('New auction in Antiques category.', '2025-01-05 10:05:00', 'AuctionUpdate', FALSE, 18, 17),
('Your bid on "Vintage Typewriter" was outbid.', '2025-01-11 16:05:00', 'BidUpdate', FALSE, 17, 18),
('Auction "Antique Map Collection" is ending in 24 hours.', '2025-02-14 14:00:00', 'AuctionUpdate', FALSE, 19, 19);


-- Populate Money Manager
INSERT INTO money_manager (amount, operation_date, state, type, user_id) VALUES
(1000, '2024-10-01 09:00:00', 'Approved', 'Deposit', 1),
(500, '2024-10-05 14:30:00', 'Approved', 'Deposit', 2),
(750, '2024-10-15 11:45:00', 'Approved', 'Deposit', 4),
(1200, '2024-10-20 16:20:00', 'Approved', 'Deposit', 5),
(300, '2024-11-01 10:10:00', 'Approved', 'Deposit', 6),
(1500, '2024-11-05 13:30:00', 'Approved', 'Deposit', 7),
(200, '2024-11-10 09:45:00', 'Pending', 'Withdraw', 2),
(800, '2024-11-15 15:00:00', 'Approved', 'Deposit', 8),
(100, '2024-11-20 11:30:00', 'Approved', 'Withdraw', 9),
(2000, '2024-11-25 14:15:00', 'Pending', 'Deposit', 10),
(1500, '2024-12-01 10:00:00', 'Approved', 'Deposit', 11),
(3000, '2024-12-05 13:45:00', 'Approved', 'Deposit', 12),
(500, '2024-12-10 11:30:00', 'Approved', 'Withdraw', 13),
(2500, '2024-12-15 14:20:00', 'Approved', 'Deposit', 14),
(1000, '2024-12-20 16:00:00', 'Pending', 'Withdraw', 15),
(1800, '2024-12-25 12:30:00', 'Approved', 'Deposit', 16),
(700, '2024-12-30 10:45:00', 'Approved', 'Deposit', 17),
(1200, '2025-01-05 09:15:00', 'Approved', 'Withdraw', 18),
(900, '2025-01-15 11:00:00', 'Approved', 'Deposit', 20);

INSERT INTO money_manager (reference, amount, operation_date, state, type, user_id) VALUES
('notPeter', 2200, '2025-01-10 15:30:00', 'Pending', 'Deposit', 19);


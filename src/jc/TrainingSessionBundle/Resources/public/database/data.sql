
INSERT INTO contact (id, civility, firstname, lastname, phone, mobile, mail) VALUES 
('1', 'Mr', 'Alpha', 'CONTACT', '01.11.11.11.11', '06.11.11.11.11', 'contact.alpha@yopmail.com'),
('2', 'Mr', 'Bravo', 'CONTACT', '01.22.22.22.22', '06.22.22.22.22', 'contact.bravo@yopmail.com'),
('3', 'Mme', 'Charlie', 'CONTACT', '01.33.33.33.33', '06.33.33.33.33', 'contact.charlie@yopmail.com');

INSERT INTO location (id, name, address, city, zipCode, showMap, latitude, longitude, zoom) VALUES 
('1', 'Localisation Alpha', '11 rue alpha', 'ALPHAVILLE', '01111', '1', '48.8611', '2.34558', '11'),
('2', 'Localisation Bravo', '22 rue bravo', 'BRAVOVILLE', '02222', '1', '45.7500', '4.8500', '11'),
('3', 'Localisation Charlie', '33 rue charlie', 'CHARLIEVILLE', '03333', '0', '48.8611', '2.34558', '11');

INSERT INTO trainingSession (id, title, description, date, timeHourStart, timeMinuteStart, timeHourEnd, timeMinuteEnd, pictureUrl, contactId, locationId) VALUES 
('1', 'Stage Alpha', 'sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores', '2014-09-11 14:10:28', '13', '45', '16', '15', '/userfiles/stages/Alpha.jpg', '1', '2'),
('2', 'Stage Bravo', 'gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam', '2014-09-26 14:10:28', '14', '0', '16', '30', '/userfiles/stages/Bravo.jpg', '3', '1'),
('3', 'Stage Charlie', 'invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor', '2014-10-11 14:10:28', '14', '0', '16', '30', '/userfiles/stages/Charlie.jpg', '3', '1'),
('4', 'Stage Delta', 'ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no', '2014-10-26 14:10:28', '15', '30', '18', '0', '/userfiles/stages/Delta.jpg', '3', '3'),
('5', 'Stage Echo', 'elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum', '2014-11-10 14:10:28', '16', '30', '19', '0', '/userfiles/stages/Echo.jpg', '1', '1'),
('6', 'Stage Fox-trot', 'est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et', '2014-11-25 14:10:28', '10', '0', '12', '30', '/userfiles/stages/Fox-trot.jpg', '2', '3'),
('7', 'Stage Golf', 'nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', '2014-12-10 14:10:28', '11', '15', '13', '45', '/userfiles/stages/Golf.jpg', '1', '2'),
('8', 'Stage Hotel', 'et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam', '2014-12-25 14:10:28', '16', '15', '18', '45', '/userfiles/stages/Hotel.jpg', '2', '3'),
('9', 'Stage India', 'tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum', '2015-01-09 14:10:28', '13', '15', '15', '45', '/userfiles/stages/India.jpg', '2', '2'),
('10', 'Stage Juliet', 'At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt', '2015-01-24 14:10:28', '12', '30', '15', '0', '/userfiles/stages/Juliet.jpg', '1', '3');

INSERT INTO trainingsessioncomment (id, text, date, authorId, trainingSessionId) VALUES
(1, 'Quis, ex, vel eaque minus quidem repudiandae delectus? Nemo, nulla, voluptatem eius officia iste placeat impedit est pariatur quisquam culpa consectetur facilis suscipit expedita maxime deleniti sit alias.', '2014-11-12 00:00:00', 4, 9),
(2, 'Debitis numquam sapiente omnis tempore eos quod! Ex, aut, quas, fugiat ducimus alias et unde perspiciatis doloremque quam similique vero officiis magni dicta quia non dignissimos vitae blanditiis mollitia eligendi ullam neque beatae delectus quae aliquam eaque sunt commodi eveniet obcaecati sed ipsum qui nulla illum sit laborum cum tempora rerum iure tempore quos pariatur.', '2014-11-16 00:00:00', 4, 9);

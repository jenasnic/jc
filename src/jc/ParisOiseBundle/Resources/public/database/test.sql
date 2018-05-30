
INSERT INTO `construction` (`id`, `reference`, `firstname1`, `lastname1`, `birthDate1`, `birthPlace1`, `nationality1`, `job1`, `phone1`, `mail1`, `firstname2`, `lastname2`, `birthDate2`, `birthPlace2`, `nationality2`, `job2`, `phone2`, `mail2`, `customerUnion`, `customerStreet1`, `customerStreet2`, `customerZip`, `customerCity`, `constructionStreet1`, `constructionStreet2`, `constructionZip`, `constructionCity`) VALUES
(1, 'Alpha', 'Alphonse', 'DUPONT', '1970-11-15 00:00:00', 'Paris', 'France', 'Ingénieur', '0123456789', 'aphonse.dupont@yopmail.com', 'Gertrude', 'DUPONT', '1972-05-17 00:00:00', 'Lyon', 'France', 'Commerciale', '01987654e32', 'gertrude.dupont@yopmail.com', 'Mariés', '11 rue de Paris', 'Appt 36', '75000', 'PARIS', '15 rue de la prairie', NULL, '60100', 'CREIL');


INSERT INTO `contact` (`id`, `firstname`, `lastname`, `phone`, `mobile`, `mail`, `construction_id`, `type_id`) VALUES
(1, 'Alpha', 'AAA', '0123451111', '0698761111', 'alpha.aaa@yopmail.com', 1, 3),
(2, 'Bravo', 'BBB', '0123452222', '0698762222', 'bravo.bbb@yopmail.com', 1, 2),
(3, 'Charlie', 'CCC', '0123453333', '0698763333', 'charlie.ccc@yopmail.com', 1, 1),
(4, 'Delta', 'DDD', '0123454444', '0698764444', 'delta.ddd@yopmail.com', 1, 4);

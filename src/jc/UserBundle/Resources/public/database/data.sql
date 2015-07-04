
TRUNCATE TABLE `user`;
TRUNCATE TABLE `role`;
TRUNCATE TABLE `user_role`;

-- --------------------------------------------------------

--
-- Contenu de la table `user` (compte admin / admin)
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `mail`, `username`, `password`, `salt`) VALUES
(1, 'Admin', '', 'admin@yopmail.com', 'admin', 'nhDr7OyKlXQju+Ge/WKGrPQ9lPBSUFfpK+B1xqx/+8zLZqRNX0+5G1zBQklXUFy86lCpkAofsExlXiorUcKSNQ==', NULL);

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id`, `code`, `name`, `comment`) VALUES
(1, 'ROLE_ADMIN', 'Rôle adminsitrateur', NULL),
(2, 'ROLE_USER', 'Rôle utilisateur', NULL);

--
-- Contenu de la table `user_role`
--

INSERT INTO `user_role` (`userId`, `roleId`) VALUES
(1, 1);



--
-- Jeu de données (login / mot de passe identique)
--

INSERT INTO user (id, firstname, lastname, mail, username, password, salt) VALUES 
('3', 'Avhusy', 'ECREW', 'avhusy.ECREW@yopmail.com', 'user3', 'CbqDQq+8rH11ISiKvGKQ79lbwLgAsUs7h554yT8gh6EmaZkxv0lwKGGEwS4fzJT20YUuK7lb5HPA6QaqnAWLDw==', NULL),
('4', 'Nexzu', 'CODNI', 'nexzu.CODNI@yopmail.com', 'user4', 'V84YCPl159W0VGkNNWYuLsVbLrcH5AcEbpY2Z1Qs1rKSNGOVbFXgLIf1njNbp7ljJwGQPdT+fuoha6ktKbiNHA==', NULL),
('5', 'Ycqyt', 'JYLPI', 'ycqyt.JYLPI@yopmail.com', 'user5', 'gda6fA/A8QnP7Dk86kcuHupltvYKbBYQgvL4+va5JrCziLpAFuZNnUczF0wsYr+wy+AlkcC5gploNe+tIfPpIw==', NULL),
('6', 'Ywcit', 'YNSUKU', 'ywcit.YNSUKU@yopmail.com', 'user6', 'uXUVDklwG9xe3rJ6YJjQfnfialj15+QGQDcHjaGVRBR0qJqhW9ydWkpZL9/+ciovoyb8cxpMRvzjpKYzNdgdzg==', NULL),
('7', 'Gapsi', 'EXHEQ', 'gapsi.EXHEQ@yopmail.com', 'user7', 'ijxSUeVPOeXmuhYzhN92ZY8HVtdq0m/iAbltO6Q/zluJ9uq42efsRfM+J+OpFAq7HdA6GpOtsDhyelR295tJaQ==', NULL);

INSERT INTO `user_role` (`userId`, `roleId`) VALUES
(3, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2);

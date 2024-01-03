Insert into membres (id, codeMembre, nomMembre,prenomMembre, adresseMembre, telMembre, mailMembre, photoMembre, dateAdhesionMembre, agent) values
(1, 'YMAD1', 'Diallo', 'Ibrahima', 'Hamdallaye', '6342532556', 'ibrahima@gmal.com', 'hdkadjd', '2023-12-04', 1),
(2, 'YMAD2', 'Sow', 'Kadiatou', 'Hamdallaye', '6342532556', 'ibrahima@gmal.com', 'hdkadjd', '2023-12-04', 1),
(3, 'YMAD3', 'Sylla', 'Fatoumata', 'Hamdallaye', '6342532556', 'ibrahima@gmal.com', 'hdkadjd', '2023-12-04', 1);

-- Ajout de l'adminiatrateur
Insert into users (id, email, password, role) values(1, 'ibrahima@gmal.com', '1234', 'admin');
Insert into admins values(1, 'YMAD1', 'Diallo', 'Ibrahima', 'Hamdallaye', '6342532556', 'ibrahima@gmal.com', 'hdkadjd', '2023-12-04', 1, ' 2023-12-21 16:13:0', ' 2023-12-21 16:13:0');


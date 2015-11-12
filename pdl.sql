-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: mysql.netsons.com:3306
-- Generato il: Nov 12, 2015 alle 18:04
-- Versione del server: 5.5.43-log
-- Versione PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qdytaqlz_pdl`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `atto`
--

CREATE TABLE IF NOT EXISTS `atto` (
  `id_scheda` int(11) NOT NULL,
  `id_atto` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `luogo` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `inizio` int(11) NOT NULL,
  `fine` int(11) NOT NULL,
  PRIMARY KEY (`id_atto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `atto`
--

INSERT INTO `atto` (`id_scheda`, `id_atto`, `nome`, `luogo`, `data`, `inizio`, `fine`) VALUES
(23, 2, 'XML Prague 2012', 'Univ ersity of Econo', '2012-02-10', 1, 215);

-- --------------------------------------------------------

--
-- Struttura della tabella `capitolo`
--

CREATE TABLE IF NOT EXISTS `capitolo` (
  `id_scheda` int(11) NOT NULL,
  `id_capitolo` int(11) NOT NULL AUTO_INCREMENT,
  `titolo_libro` varchar(70) NOT NULL,
  `curatore` varchar(20) NOT NULL,
  `casa_editrice` varchar(20) NOT NULL,
  `inizio` int(11) NOT NULL,
  `fine` int(11) NOT NULL,
  PRIMARY KEY (`id_capitolo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `capitolo`
--

INSERT INTO `capitolo` (`id_scheda`, `id_capitolo`, `titolo_libro`, `curatore`, `casa_editrice`, `inizio`, `fine`) VALUES
(10, 1, 'Programmazione web lato server', 'Vincenzo della Mea', 'Apogeo', 341, 353),
(11, 2, 'Essential PHP Security', 'Tizo Caio, Sempronio', 'O''Reilly', 0, 55);

-- --------------------------------------------------------

--
-- Struttura della tabella `doctecnico`
--

CREATE TABLE IF NOT EXISTS `doctecnico` (
  `id_doctecnico` int(11) NOT NULL AUTO_INCREMENT,
  `id_scheda` int(11) NOT NULL,
  PRIMARY KEY (`id_doctecnico`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dump dei dati per la tabella `doctecnico`
--

INSERT INTO `doctecnico` (`id_doctecnico`, `id_scheda`) VALUES
(4, 28),
(48, 24),
(49, 26);

-- --------------------------------------------------------

--
-- Struttura della tabella `libro`
--

CREATE TABLE IF NOT EXISTS `libro` (
  `id_scheda` int(11) NOT NULL,
  `id_libro` int(11) NOT NULL AUTO_INCREMENT,
  `casa_editrice` varchar(20) NOT NULL,
  `edizione` varchar(10) NOT NULL,
  PRIMARY KEY (`id_libro`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dump dei dati per la tabella `libro`
--

INSERT INTO `libro` (`id_scheda`, `id_libro`, `casa_editrice`, `edizione`) VALUES
(12, 14, 'W3C', 'Prima'),
(18, 15, 'prima', 'Apogeo');

-- --------------------------------------------------------

--
-- Struttura della tabella `rivista`
--

CREATE TABLE IF NOT EXISTS `rivista` (
  `id_scheda` int(11) NOT NULL,
  `id_rivista` int(11) NOT NULL AUTO_INCREMENT,
  `volume` varchar(10) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `inizio` int(11) NOT NULL,
  `fine` int(11) NOT NULL,
  PRIMARY KEY (`id_rivista`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `rivista`
--

INSERT INTO `rivista` (`id_scheda`, `id_rivista`, `volume`, `numero`, `inizio`, `fine`) VALUES
(13, 1, '', '', 0, 0),
(14, 2, '28', '2', 183, 200),
(15, 3, '12', '2', 216, 234),
(16, 4, '28', '5', 1, 13),
(17, 5, '40', '6', 53, 61),
(25, 8, '1', '1', 5, 14),
(28, 9, '', '', 0, 0),
(29, 10, '48', '3', 115, 117);

-- --------------------------------------------------------

--
-- Struttura della tabella `scheda`
--

CREATE TABLE IF NOT EXISTS `scheda` (
  `id_scheda` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  `email_utente` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `autore` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8_unicode_ci NOT NULL,
  `privato` tinyint(1) NOT NULL,
  `anno` int(11) NOT NULL,
  `url` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_scheda`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dump dei dati per la tabella `scheda`
--

INSERT INTO `scheda` (`id_scheda`, `titolo`, `email_utente`, `autore`, `keywords`, `descrizione`, `privato`, `anno`, `url`) VALUES
(10, 'Tecnologie per il Web 2.0', 'catapanomarco@gmail.com', 'Vincenzo Della Mea', 'web, php, programmazione, javascript', 'Questo volume introduce alla programmazione web lato server utilizzando due tecnologie tra le piu'' diffuse, PHP e Java Enterprise Edition, e approfondisce i temi di interesse più generale come l’utilizzo dei sistemi di gestione di basi di dati.', 0, 2011, 'http://www.apogeonline.com/2011/libri/9788850331079/ebook/pdf/3107_capitolo6Parte.pdf'),
(11, 'Php Security', 'catapano@mail.com', 'Chris Shiflett', 'php, security, sql', 'Security is a measurement, not a characteristic. It is unfortunate that many software projects list security as a simple requirement to be met. Is it secure? This question is as subjective as\r\nasking if something is hot. Security must be balanced with expense. It is easy and relatively inexpensive to provide a sufficient level of security\r\nfor most applications.', 0, 2004, 'http://www.rootsecure.net/content/downloads/pdf/php_security.pdf'),
(12, 'Extensible Markup Language (XML)', 'marcoamadeog@gmail.com', 'Tim Bray, Jean Paoli', 'xml, manuale', 'The Extensible Markup Language (XML) is a subset of SGML that is completely described in this document. Its goal is to enable generic SGML to be served, received, and processed on the Web in the way that is now possible with HTML. XML has been designed for ease of implementation and for interoperability with both SGML and HTML.', 0, 2006, 'http://www.w3pdf.com/W3cSpec/XML/2/REC-xml11-20060816.pdf'),
(13, 'On the Criteria To Be Used in Decomposing Systems into Modules', 'marcoamadeog@gmail.com', 'R. Morris', 'programming, techniques', 'This paper discusses modularization as a mechanism for improving the flexibility and comprehensibility of a system while allowing the shortening of its development time. The effectiveness of a "modularization" is dependent upon the criteria used in dividing the system into modules.', 1, 1972, 'https://www.cs.umd.edu/class/spring2003/cmsc838p/Design/criteria.pdf'),
(14, 'Simplifying and Isolating Failure-Inducing Input', 'marcoamadeog@gmail.com', 'Andreas Zeller', 'Failure, Failure-Inducing', 'Given some test case, a program fails. Which circumstances of the test case are responsible for the particular failure? The Delta Debugging algorithm generalizes and simplifies the failing test case to a minimal test case that still produces the failure. It also isolates the difference between a passing and a failing test case. In a case study, the Mozilla web browser crashed after 95 user actions. Our prototype implementation automatically simplified the input to three relevant user actions. Likewise, it simplified 896 lines of HTML to the single line that caused the failure. The case study required 139 automated test runs or 35 minutes on a 500 MHz PC.', 0, 2002, 'http://www.cs.umd.edu/class/spring2003/cmsc838p/VandV/delta.pdf'),
(15, 'The Concept of Dynamic Analysis', 'marcoamadeog@gmail.com', 'Thomas Ball', 'Dynami, Analysis', 'Dynamic analysis is the analysis of the properties of a run- ning program. In this paper, we explore two new dynamic analyses based on program profiling', 0, 1999, 'http://www.cs.umd.edu/class/spring2003/cmsc838p/Code/dynamic.pdf'),
(16, 'Using Version Control Data to Evaluate the Impact of Software Tools', 'marcoamadeog@gmail.com', 'David Atkins, Thomas Ball', 'Software, Tools', 'Software tools can improve the quality and maintainability of software, but are expensive to acquire, deploy, and maintain, especiallyinlargeorganizations.Weexplorehowtoquantifytheeffectsofasoftwaretoolonceithasbeendeployedinadevelopment environment.', 1, 2002, 'http://www.cs.umd.edu/class/spring2003/cmsc838p/Evolution/versionData.pdf'),
(17, 'How Microsoft Builds Software', 'marcoamadeog@gmail.com', 'ilds Michael A. Cusumano, Rich', 'Microsoft,  Software', 'Since the mid-1980s, Microsoft and other PC software companies have grad- ually reorganized the way they build software products in response to quality problems and delayed deliveries [10]. Many have also found it necessary to organize larger teams in order to build up-to-date PC software products that now consist of hundreds of thousands or even millions of lines of source code and require hundreds of people to build and test over periods of one or more', 0, 1997, 'http://www.cs.umd.edu/class/spring2003/cmsc838p/Process/microsoftProcess.pdf'),
(18, 'Laboratorio SQL', 'marcoamadeog@gmail.com', 'Marco Ferrero', 'sql, database', 'il termine inglese database vuol dire letteralmente base di dati e si usa come raccolta di dati.', 0, 2000, ''),
(19, 'Laboratorio SQL', 'marcoamadeog@gmail.com', 'Marco Ferrero', 'sql, database', 'il termine inglese database vuol dire letteralmente base di dati e si usa come raccolta di dati.', 0, 2000, 'http://books.google.it/books?hl=it&lr=&id=D-AyTsQW3HsC&oi=fnd&pg=PA1&dq=libro+sql&ots=NRkDb4V-Mn&sig=k4cUNvo64lqJpzQgB-aeHuEAAo0#v=onepage&q=libro%20sql&f=false'),
(23, 'XML Prague 2012', 'catapanomarco@gmail.com', 'A van Kesteren', 'xml, conference', 'This publication contains papers presented at XML Prague 2012. XML\r\nPrague is a\r\nconference on XML for developers, markup geeks,\r\ninformation managers..', 0, 2012, 'http://archive.xmlprague.cz/2012/files/xmlprague-2012-proceedings.pdf'),
(24, 'Piccola guida alla stesura di una relazione scientifica', 'catapanomarco@gmail.com', 'Giovanni Righini', 'guida relazione, relazione scientifica, scrittura', 'Questa guida e'' dedicata a tutti gli studenti che sono in difficolta''  quando devono mettere per iscritto una relazione sul loro lavoro: una relazione, e ancor più una tesina o una tesi, non deve essere una penitenza ne'' per chi la scrive ne'' per chi la leggera''. Per evitare di dover correggere sempre gli stessi errori, mi sono deciso a mettere a mia volta per iscritto alcune regole e consigli per la stesura e per la revisione dei testi.', 0, 1999, 'http://homes.di.unimi.it/righini/Didattica/Guida_relazione.pdf'),
(25, 'HTML 5: il futuro della lingua franca del Web', 'catapanomarco@gmail.com', 'Paolo Sordi', 'html5, xhtml, browser, compatibilitÃ ', 'Secondo Jeffrey Zeldm\r\nan, nel 2003 il 99,9% dei siti Web aveva un markup obsoleto e\r\nXHTML era il futuro. Sei anni dopo, mentre lo sviluppo di XHTML viene abbandonato in favore di HTML5, gli autori del Web\r\naffrontano una nuova verifica del concetto di obsolescenza.', 0, 2009, 'http://www.icomit.it/pub/2009/02/02sordi.pdf'),
(26, 'Ajax: A New Approach to Web Applications', 'catapanomarco@gmail.com', 'Jesse James Garrett', 'ajax, new approach,', 'Questo documento contiene una introduzione ad Ajax.', 0, 2005, 'https://courses.cs.washington.edu/courses/cse490h/07sp/readings/ajax_adaptive_path.pdf'),
(28, 'Normative sul risparmio energetico in agricoltura', 'catapanomarco@gmail.com', 'C. A. Campiotti, A. Albanese', 'energia, risparmio, rinnovabili', 'Il rapporto tecnico fornisce un quadro di sintesi della politica energetica dell''Unione Europea (UE) e della\r\nsua evoluzione negli ultimi anni: gli aspetti del risparmio energetico e delle energie rinnovabili sono analizzati con particolare riferimento al settore agricoltura.\r\n\r\nLa prima parte di questo documento fornisce un quadro di sintesi della politica energetica dell''Unione Europea (UE) con particolare riferimento agli aspetti del risparmio energetico e dell''utilizzo delle energie rinnovabili in agricoltura. Vengono riportate le caratteristiche generali della politica energetica comunitaria, il contesto di riferimento, gli obiettivi complessivi e i relativi risultati attesi.', 0, 2010, 'http://www.efficienzaenergetica.enea.it/doc/agricoltura/NormativaRisparmioEnergetico.pdf'),
(29, 'The Bubble of Web Visibility', 'catapanomarco@gmail.com', 'Marco Gori, Ian Witten', 'visibility, web, page promotion', 'The Web seems like a Borgesian library with a huge\r\namount of information. Access to this treasure is\r\nmediated by dragons in the guise of search engine operators who compete amongst themselves for\r\ndominance. The battleground is so hostile that few will surviveâ€”indeed, just one will likely achieve overall dominance in all but specialist corners of the library...', 0, 2005, 'http://www.mozalami.com/web-semantique/analyse-pre-penguin-semantique.pdf');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `nome` varchar(30) NOT NULL,
  `cognome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` text NOT NULL,
  `responsabile` tinyint(1) NOT NULL,
  `attivato` tinyint(1) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`nome`, `cognome`, `email`, `pass`, `responsabile`, `attivato`) VALUES
('Marco', 'Catapano', 'catajoe@tiscali.it', '2ebe429df1dd983fdbf00d95efa8f1db', 0, 1),
('Marco', 'Catapano', 'catapanomarco@gmail.com', '2ebe429df1dd983fdbf00d95efa8f1db', 1, 1),
('Roberto', 'Masellis', 'robertomasellis@gmail.com', 'c1bfc188dba59d2681648aa0e6ca8c8e', 1, 1),
('Marco', 'Amadeo', 'marcoamadeog@gmail.com', '050cd7281205aa0f60db05138b2c004f', 1, 1),
('Roberto', 'Masellis', 'bau@trim.it', '25d55ad283aa400af464c76d713c07ad', 0, 1),
('aaa', 'aaa', 'aa@aa.aa', '74b87337454200d4d33f80c4663dc5e5', 0, 0),
('Roberto', 'Masellis', 'robyrap1992@hotmail.it', '14aa7fb7dfe078c442945cc1c4127925', 0, 1),
('biin', '', 'affffrefa@aa.aa', 'd41d8cd98f00b204e9800998ecf8427e', 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

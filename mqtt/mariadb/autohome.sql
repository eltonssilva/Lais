-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 23/09/2019 às 14:58
-- Versão do servidor: 10.4.8-MariaDB-1:10.4.8+maria~bionic
-- Versão do PHP: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `autohome`
--
CREATE DATABASE IF NOT EXISTS `autohome` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `autohome`;

SELECT CAST('' AS UNSIGNED);
-- --------------------------------------------------------

--
-- Estrutura para tabela `alerta`
--

CREATE TABLE `alerta` (
  `id` int(11) UNSIGNED NOT NULL,
  `tipo_alerta` varchar(18) NOT NULL,
  `habilitar` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Habilitar Alerta',
  `Quantidade_dia` int(11) NOT NULL COMMENT 'Quantidade de Alerta por dia',
  `tempo_entre` bigint(20) NOT NULL COMMENT 'tempo minimo entre duas alertas iguais',
  `data_ultima_alerta` datetime NOT NULL COMMENT 'Data e hora da ultima alerta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ambiente`
--

CREATE TABLE `ambiente` (
  `id` int(11) UNSIGNED NOT NULL,
  `Descricao` varchar(128) NOT NULL,
  `codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `ambiente`
--

INSERT INTO `ambiente` (`id`, `Descricao`, `codigo`) VALUES
(1, 'AutoDomo', 3),
(2, 'Sala', 3),
(3, 'Quarto', 3),
(4, 'Garagem', 3),
(5, 'Cozinha', 3),
(6, 'Banheiro', 3),
(7, 'Área Externa', 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `associar_widget`
--

CREATE TABLE `associar_widget` (
  `id` int(11) NOT NULL,
  `pin_dispositivo` varchar(17) NOT NULL,
  `id_agrupador` int(11) NOT NULL,
  `id_widget2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cena`
--

CREATE TABLE `cena` (
  `id` int(11) NOT NULL,
  `codigo_cena` varchar(17) NOT NULL,
  `topico_atuar_cena` varchar(128) NOT NULL,
  `acao_cena` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comandos_infrared`
--

CREATE TABLE `comandos_infrared` (
  `id` int(11) NOT NULL,
  `descricaocomando` varchar(22) NOT NULL,
  `tag_comando` varchar(15) NOT NULL,
  `tipoequipamento` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `comandos_infrared`
--

INSERT INTO `comandos_infrared` (`id`, `descricaocomando`, `tag_comando`, `tipoequipamento`) VALUES
(1, 'Liga/Desligar', 'POW', 2),
(2, 'Menu', 'MEN', 2),
(3, 'Incrementar Canal', 'CPL', 2),
(4, 'Decrementar Canal', 'CMI', 2),
(5, 'Aumentar Volume', 'VPL', 2),
(6, 'Diminuir Volume', 'VMI', 2),
(7, 'Mudo', 'MUD', 2),
(8, 'Guia', 'GUI', 2),
(9, 'Entrada', 'ENT', 2),
(10, 'OK', 'OK', 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `controle_ir`
--

CREATE TABLE `controle_ir` (
  `id` int(11) UNSIGNED NOT NULL,
  `dispositivo` int(11) NOT NULL,
  `descricaocomando` varchar(44) NOT NULL,
  `comando` varchar(15) NOT NULL,
  `codigo` varchar(400) NOT NULL,
  `modo` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dispositivo_type`
--

CREATE TABLE `dispositivo_type` (
  `id` int(11) UNSIGNED NOT NULL,
  `Descricao` varchar(128) NOT NULL,
  `codigo` varchar(2) NOT NULL,
  `src_imagem` varchar(128) NOT NULL,
  `type_kappelt` varchar(255) NOT NULL,
  `traits_type_kappelt` varchar(255) NOT NULL,
  `requiresActionTopic_kappelt` tinyint(1) NOT NULL DEFAULT 1,
  `requiresStatusTopic_kappelt` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `dispositivo_type`
--

INSERT INTO `dispositivo_type` (`id`, `Descricao`, `codigo`, `src_imagem`, `type_kappelt`, `traits_type_kappelt`, `requiresActionTopic_kappelt`, `requiresStatusTopic_kappelt`) VALUES
(1, 'Chave Lampada', '01', '/png/64/bulb.png', 'Light', 'OnOff', 1, 1),
(2, 'Sensor de Humidade', '02', '/png/64/drop.png', 'Thermostat', 'TempSet.Humidity', 1, 1),
(3, 'Sensor de Temperatura', '03', '/png/64/temperature.png', 'Thermostat', 'TempSet.Humidity', 1, 1),
(4, 'Nivel de Luz', '04', '/png/64/lux.png', '', '', 1, 1),
(5, 'RGB Lampada', '05', '/png/64/rgb.png', 'Light', 'OnOff-Brightness', 1, 1),
(6, 'Sensor de umidade de terra', '06', '/png/64/houseplant.png', '', '', 1, 1),
(7, 'Sensor de Pressão', '07', '/png/64/atmospheric_pressure.png', '', '', 1, 1),
(8, 'Sensor de Altitude', '08', '/png/64/altitude.png', '', '', 1, 1),
(9, 'Controle de Persiana', '09', '/png/64/persiana.png', 'Blinds', 'OpenClose', 1, 1),
(10, 'Controle ArCondicionador', '10', '/png/64/airconditioningindoor.png', 'AC', '', 1, 1),
(11, 'Controle Midia', '11', '/png/64/tv.png', '', '', 1, 1),
(12, 'Medição ', '12', '/png/64/power.png', '', '', 1, 1),
(13, 'Sensor Movimento', '13', '/png/64/motion.png', '', '', 1, 1),
(14, 'Chave (Relé)', '14', '/png/64/power button.png', 'Outlet', 'OnOff', 1, 1),
(15, 'Agrupamento de Dispositivo', '15', '/png/64/bulb.png', 'Switch', 'OnOff', 1, 1),
(16, 'Autodomum Bridge', '16', '/png/64/rf433.png', '', '', 1, 1),
(17, 'Sensor Porta', '17', '/png/64/door.png', 'Door', 'OnOff', 1, 1),
(18, 'Sensor de Qualidade do Ar', '18', '/png/64/air-quality.png', 'Purifier', '', 1, 1),
(19, 'Sensor Palma/Clamp', '19', '/png/64/clamp.png', 'Switch', 'OnOff', 1, 1),
(20, 'Porta Garagem', '20', '/png/64/garage.png', 'Switch', 'OpenClose', 1, 1),
(21, 'Alarme', '21', '/png/64/alarme.png', 'Switch', 'OpenClose', 1, 1),
(22, 'Tomada Inteligente', '22', '/png/64/socket_f.png', 'Outlet', 'OnOff', 1, 1),
(23, 'Cena', '23', '/png/64/cena.png', 'Scene', 'OnOff', 1, 1),
(24, 'Lampada dimerizavel', '24', '/png/64/bulb.png', 'Light', 'OnOff-Brightness', 1, 1),
(25, 'Controle Som', '25', '/png/64/som.png', '', '', 1, 1),
(26, 'Smart Lock', '26', '/png/64/lock_close.png', '', '', 1, 1),
(27, 'Porta Garagem', '27', '/png/64/garage.png', '', '', 1, 1),
(28, 'Irrigação', '28', '/png/64/sprinkler_off.png', '', '', 1, 1),
(29, 'Sensor de Chuva', '29', '/png/64/rainsensor_off.png', '', '', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `email` varchar(122) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT 1,
  `proprietario` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamento_infrared`
--

CREATE TABLE `equipamento_infrared` (
  `id` int(11) NOT NULL,
  `Descricao` varchar(45) NOT NULL,
  `Marca` varchar(24) NOT NULL,
  `Modelo` varchar(24) NOT NULL,
  `nomeprotocolo` varchar(16) NOT NULL,
  `numerobit` varchar(3) NOT NULL,
  `tipoprotocolo` varchar(2) NOT NULL,
  `repeticao` int(11) NOT NULL,
  `tipoequipamento` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `equipamento_infrared`
--

INSERT INTO `equipamento_infrared` (`id`, `Descricao`, `Marca`, `Modelo`, `nomeprotocolo`, `numerobit`, `tipoprotocolo`, `repeticao`, `tipoequipamento`) VALUES
(0, '', '', '', '', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_alerta`
--

CREATE TABLE `historico_alerta` (
  `int` int(11) UNSIGNED NOT NULL,
  `tipo_alerta` varchar(126) NOT NULL COMMENT 'tipo_alerta',
  `data_alerta` datetime NOT NULL COMMENT 'data_alerta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_mqtt`
--

CREATE TABLE `historico_mqtt` (
  `id` int(11) NOT NULL,
  `topico` varchar(128) NOT NULL,
  `valor` varchar(128) NOT NULL,
  `data` datetime NOT NULL,
  `id_widget` int(11) NOT NULL,
  `data_ms` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ifttt`
--

CREATE TABLE `ifttt` (
  `id` int(11) NOT NULL,
  `username_iphone` varchar(17) NOT NULL,
  `compara_sensor` varchar(15) NOT NULL,
  `valor_sensor` varchar(24) NOT NULL,
  `id_widget_atuador` int(11) NOT NULL,
  `valor_atuador` varchar(25) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `data_executado` datetime NOT NULL,
  `tipo_acao` int(1) NOT NULL COMMENT '1-acao 2-tempo',
  `quant_exec` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel`
--

CREATE TABLE `nivel` (
  `id` int(11) NOT NULL,
  `nivel` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `power`
--

CREATE TABLE `power` (
  `id` int(11) NOT NULL,
  `codigo_dispositivo` varchar(12) NOT NULL,
  `potencia` double(14,2) NOT NULL,
  `tensao` double(5,2) NOT NULL,
  `horario` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `programacao`
--

CREATE TABLE `programacao` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_dispositivo` int(11) NOT NULL,
  `data_prog` datetime NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `funcao` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `protocolo_infrared`
--

CREATE TABLE `protocolo_infrared` (
  `id` int(11) NOT NULL,
  `nomeprotocolo` varchar(16) NOT NULL,
  `tipoprotocolo` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `protocolo_infrared`
--

INSERT INTO `protocolo_infrared` (`id`, `nomeprotocolo`, `tipoprotocolo`) VALUES
(1, 'INTERNO', '00'),
(2, 'NEC', '01'),
(3, 'RAW', '02'),
(4, 'LG 01', '03'),
(5, 'Sony', '04'),
(6, 'RC5', '05'),
(7, 'RC6', '06'),
(8, 'RCMM', '07'),
(9, 'DISH', '08'),
(10, 'Sharp', '09'),
(11, 'JVC', '10'),
(12, 'SAMSUNG', '11'),
(13, 'SAMSUNG_AC', '12'),
(14, 'WHYNTER', '13'),
(15, 'AIWA_RC_T501', '14'),
(16, 'MITSUBISHI', '15'),
(17, 'MITSUBISHI2', '16'),
(18, 'DENON', '17'),
(19, 'KELVINATOR', '18'),
(20, 'MITSUBISHI_AC', '19'),
(21, 'FUJITSU_AC', '20'),
(22, 'DAIKIN', '21'),
(23, 'COOLIX', '22'),
(24, 'GREE', '23'),
(25, 'NIKAI', '24'),
(26, 'TOSHIBA_AC', '25'),
(27, 'SEND_MIDEA', '26'),
(28, 'LASERTAG', '27'),
(29, 'CARRIER_AC', '28'),
(30, 'HAIER_AC', '29'),
(31, 'HITACHI_AC', '30'),
(32, 'HITACHI_AC1', '31'),
(33, 'HITACHI_AC2', '32'),
(34, 'HaierACYRW02', '33'),
(35, 'WHIRLPOOL_AC', '34'),
(36, 'LUTRON', '35'),
(37, 'ELECTRA_AC', '36'),
(38, ' PANASONIC_AC', '37'),
(39, 'MWM', '38'),
(40, 'PIONEER', '39');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pushover`
--

CREATE TABLE `pushover` (
  `id` int(11) NOT NULL,
  `user_key` varchar(31) NOT NULL,
  `token_key` varchar(30) NOT NULL,
  `email` varchar(122) NOT NULL,
  `device` varchar(36) NOT NULL,
  `habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `qrcode`
--

CREATE TABLE `qrcode` (
  `id` int(11) NOT NULL,
  `palavra` varchar(2000) NOT NULL,
  `imei` varchar(16) NOT NULL,
  `validade` datetime NOT NULL,
  `limiteusuario` int(9) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `qrcode`
--

INSERT INTO `qrcode` (`id`, `palavra`, `imei`, `validade`, `limiteusuario`, `habilitado`) VALUES
(1, 'https://192.168.10.101/phpmyadmin/tbl_change.php?db=autohome&table=qrcode&token=9da578b428feb08e32cbe7f59d6c9741', '0', '2019-04-09 07:33:11', 10, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `rx433mhz`
--

CREATE TABLE `rx433mhz` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_widget` int(11) UNSIGNED NOT NULL,
  `codigo` varchar(16) NOT NULL COMMENT 'Codigo do Controle',
  `data_ms` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `topico` varchar(128) NOT NULL DEFAULT '/house',
  `topico_confirma` varchar(128) NOT NULL,
  `carga` varchar(128) NOT NULL,
  `carga_provavel` varchar(128) NOT NULL,
  `descricao` varchar(110) NOT NULL DEFAULT '0',
  `estado` char(1) NOT NULL DEFAULT 'X',
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rx433mhz_alarmes`
--

CREATE TABLE `rx433mhz_alarmes` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_widget` int(11) NOT NULL,
  `codigo` varchar(12) NOT NULL COMMENT 'Codigo do Controle',
  `data_ms` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `topico` varchar(128) NOT NULL DEFAULT '/house',
  `topico_confirma` varchar(128) NOT NULL,
  `carga` varchar(128) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `descricao` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rx433mhz_garage`
--

CREATE TABLE `rx433mhz_garage` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_widget` int(11) UNSIGNED NOT NULL,
  `codigo` varchar(16) NOT NULL COMMENT 'Codigo do Controle',
  `data_ms` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `topico` varchar(128) NOT NULL DEFAULT '/house',
  `topico_confirma` varchar(128) NOT NULL,
  `carga` varchar(128) NOT NULL,
  `descricao` varchar(110) NOT NULL DEFAULT '0',
  `estado` char(1) NOT NULL DEFAULT 'X',
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rx433mhz_persiana`
--

CREATE TABLE `rx433mhz_persiana` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_widget` int(11) UNSIGNED NOT NULL,
  `codigo` varchar(16) NOT NULL COMMENT 'Codigo do Controle',
  `data_ms` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `topico` varchar(128) NOT NULL DEFAULT '/house',
  `topico_confirma` varchar(128) NOT NULL,
  `carga` varchar(128) NOT NULL,
  `descricao` varchar(110) NOT NULL DEFAULT '0',
  `estado` char(1) NOT NULL DEFAULT 'X',
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rx433mhz_portas`
--

CREATE TABLE `rx433mhz_portas` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_widget` int(11) NOT NULL,
  `codigo` varchar(12) NOT NULL COMMENT 'Codigo do Controle',
  `data_ms` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `topico` varchar(128) NOT NULL DEFAULT '/house',
  `topico_confirma` varchar(128) NOT NULL,
  `carga` varchar(128) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `descricao` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rx433mhz_violacao`
--

CREATE TABLE `rx433mhz_violacao` (
  `id` int(11) UNSIGNED NOT NULL,
  `codigo` varchar(12) NOT NULL COMMENT 'Codigo do Controle',
  `mensagem` varchar(125) NOT NULL,
  `data_ms` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `topico` varchar(128) NOT NULL DEFAULT '/house',
  `descricao` varchar(110) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sensores_instalado`
--

CREATE TABLE `sensores_instalado` (
  `id` int(11) NOT NULL,
  `tipo_sensor` char(2) NOT NULL,
  `sequencia` int(3) NOT NULL,
  `data_ultimo_ms` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `tempo_atualizacao` int(11) NOT NULL DEFAULT 5000,
  `descricao` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sensoriamento`
--

CREATE TABLE `sensoriamento` (
  `id` int(11) NOT NULL,
  `tipo` char(2) NOT NULL,
  `sequencia` int(3) NOT NULL,
  `valor` float(6,3) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `servidor`
--

CREATE TABLE `servidor` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `pin` varchar(32) NOT NULL,
  `usuario` varchar(128) NOT NULL,
  `ip` varchar(17) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `usuarioadmin` varchar(128) NOT NULL,
  `senhaadmin` varchar(32) NOT NULL,
  `usu_bb` varchar(128) NOT NULL,
  `se_bb` varchar(257) NOT NULL,
  `senhamqttlocal_cripto` varchar(257) NOT NULL,
  `email` varchar(128) NOT NULL,
  `chavelocal` varchar(62) NOT NULL,
  `chavedispositivo` varchar(12) NOT NULL,
  `user_gbridge` varchar(10) NOT NULL,
  `userid_gh` varchar(255) NOT NULL,
  `apikey_gh` varchar(255) NOT NULL,
  `bearertoken` varchar(400) NOT NULL,
  `apikey_id` int(11) NOT NULL,
  `usermqtt_gh` varchar(255) NOT NULL,
  `senha_user_gh` varchar(32) NOT NULL,
  `senhamqtt_gh` varchar(32) NOT NULL,
  `adddevicehabilitado` tinyint(1) NOT NULL,
  `firmware` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `servidor`
--

INSERT INTO `servidor` (`id`, `nome`, `pin`, `usuario`, `ip`, `senha`, `usuarioadmin`, `senhaadmin`, `usu_bb`, `se_bb`, `senhamqttlocal_cripto`, `email`, `chavelocal`, `chavedispositivo`, `user_gbridge`, `userid_gh`, `apikey_gh`, `bearertoken`, `apikey_id`, `usermqtt_gh`, `senha_user_gh`, `senhamqtt_gh`, `adddevicehabilitado`, `firmware`) VALUES
(1, 'AutoDomo Padrao', 'c400000000000000', 'autodomo', '192.168.10.101', '5a52f891902098b1446706d1fd692ff2', 'admin', '5a52f891902098b1446706d1fd692ff2', 'autohome', 'comida05', 'PBKDF2$sha512$100000$QXl3bjd0Qnd2WE1nZ3VwYg==$dJCMzQEAfNliPjYumERkvio7HCKzOuC7b7gqsCjpFWzoEQtwgOXnFHfaeZBvKR8JsTI/BvPkBABsCVwWu11Jzw==' ,'bancada@autodomum.com.br', '23534059835', 'ABCDEF254552', 'u2264', '2264', 'zG3dT5GzMxkxUQGx:CTSII3gQAG7CSjLCLdAhmkYuJetunNjv28CtLwcJMY92mHvF2uetq8QkMeVjNwEH9WYyVfI7sRijrS5XlHaGGjWACkMziUx0NG8WvrX2ncQQkngmztpn6H5otk4U5ZPJ', '', 436, 'gbridge-u2264', 'Comida$05$', 'Comida$05$', 1,'3.0');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sms`
--

CREATE TABLE `sms` (
  `id` int(11) UNSIGNED NOT NULL,
  `proprietario` varchar(128) NOT NULL,
  `numerosms` varchar(14) NOT NULL,
  `client_secret_` varchar(12) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_sensor`
--

CREATE TABLE `tipo_sensor` (
  `id` int(11) NOT NULL,
  `tipo_sensor` char(2) NOT NULL,
  `descricao_sensor` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `tipo_sensor`
--

INSERT INTO `tipo_sensor` (`id`, `tipo_sensor`, `descricao_sensor`) VALUES
(1, 'T', 'Sensor de Temperatura'),
(2, 'L', 'Sensor de Nivel'),
(3, 'M', 'Sensor de Umidade'),
(4, 'P', 'Sensor de Pressão'),
(5, 'V', 'Sensor de Vibração'),
(6, 'S', 'Sensor de Velocidade_Frequenci'),
(7, 'P', 'Sensor de Pressão'),
(8, 'F', 'Sensor de Vazão'),
(9, 'E', 'Sensor de Tensão (FEM)');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(8) UNSIGNED NOT NULL,
  `email` varchar(80) NOT NULL,
  `administrador` tinyint(1) NOT NULL DEFAULT 0,
  `imei` varchar(80) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fone` varchar(128) NOT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ultimo_Acesso` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `habilitado` tinyint(1) NOT NULL DEFAULT 0,
  `notificacao` tinyint(4) NOT NULL DEFAULT 1,
  `somente_local` tinyint(1) NOT NULL DEFAULT 0,
  `CASA` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `administrador`, `imei`, `token`, `fone`, `data_criacao`, `ultimo_Acesso`, `habilitado`, `notificacao`, `somente_local`, `CASA`) VALUES
(1, 'cliente@cliente.com.br', 1, '8693880438021550', 'csgQSmmkNVs:APA91bHxTHZUnmb2RmC7QxkWr1Vm9ORN5J8MVLMzpHhd-E1xnb5tn6d1TSENyXWr9q74LOR3BcRAtZTDxb1nnhNHEuornA8vMwLPCYlgpYBReby_d5lDT6CU89ePlV2DHFCziuJeAt3h', '', '2019-09-09 20:16:10', '2019-09-11 14:29:53', 1, 1, 1, 'Bancada');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_admin`
--

CREATE TABLE `usuario_admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `usuario` varchar(128) NOT NULL,
  `senha` varchar(128) NOT NULL,
  `acesso` varchar(2) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_widget`
--

CREATE TABLE `usuario_widget` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_widget` int(11) NOT NULL,
  `habilitado` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `widget`
--

CREATE TABLE `widget` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_ligado` int(11) NOT NULL DEFAULT 0,
  `Descricao` varchar(31) NOT NULL,
  `username_iphone` varchar(17) NOT NULL,
  `pin_iphone` varchar(10) NOT NULL,
  `ordem` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `tipo` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `tipo_geral` int(11) NOT NULL,
  `ambiente` int(11) NOT NULL DEFAULT 1,
  `dispositivo_fisico` tinyint(1) NOT NULL DEFAULT 1,
  `proprietario` tinyint(1) NOT NULL DEFAULT 1,
  `setName0` varchar(128) NOT NULL,
  `setName1` varchar(128) NOT NULL,
  `setName2` varchar(128) NOT NULL,
  `setName3` varchar(128) NOT NULL,
  `setSubTopic0` varchar(128) NOT NULL,
  `setSubTopic1` varchar(128) NOT NULL,
  `setSubTopic2` varchar(128) NOT NULL,
  `setSubTopic3` varchar(128) NOT NULL,
  `setPubTopic0` varchar(128) NOT NULL,
  `publishValue` varchar(128) NOT NULL,
  `publishValue2` varchar(128) NOT NULL,
  `label` varchar(128) NOT NULL,
  `label2` varchar(128) NOT NULL,
  `additionalValue` varchar(128) NOT NULL,
  `additionalValue2` varchar(128) NOT NULL,
  `additionalValue3` varchar(128) NOT NULL,
  `setPrimaryColor0` int(11) NOT NULL,
  `setPrimaryColor1` int(11) NOT NULL,
  `setPrimaryColor2` int(11) NOT NULL,
  `setPrimaryColor3` int(11) NOT NULL,
  `retained` tinyint(1) NOT NULL DEFAULT 0,
  `decimalMode` tinyint(1) NOT NULL DEFAULT 0,
  `mode` int(6) NOT NULL,
  `onShowExecute` varchar(128) NOT NULL,
  `onReceiveExecute` varchar(128) NOT NULL,
  `formatMode` varchar(128) NOT NULL,
  `habilitado` tinyint(1) NOT NULL,
  `convidado` tinyint(1) NOT NULL,
  `device_id_kappelt` int(11) NOT NULL DEFAULT 0,
  `type_kappelt` varchar(255) NOT NULL,
  `traits_type_kappelt` varchar(255) NOT NULL,
  `requiresActionTopic_kappelt` tinyint(1) NOT NULL DEFAULT 1,
  `requiresStatusTopic_kappelt` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Despejando dados para a tabela `widget`
--

INSERT INTO `widget` (`id`, `id_ligado`, `Descricao`, `username_iphone`, `pin_iphone`, `ordem`, `tipo`, `tipo_geral`, `ambiente`, `dispositivo_fisico`, `proprietario`, `setName0`, `setName1`, `setName2`, `setName3`, `setSubTopic0`, `setSubTopic1`, `setSubTopic2`, `setSubTopic3`, `setPubTopic0`, `publishValue`, `publishValue2`, `label`, `label2`, `additionalValue`, `additionalValue2`, `additionalValue3`, `setPrimaryColor0`, `setPrimaryColor1`, `setPrimaryColor2`, `setPrimaryColor3`, `retained`, `decimalMode`, `mode`, `onShowExecute`, `onReceiveExecute`, `formatMode`, `habilitado`, `convidado`, `device_id_kappelt`, `type_kappelt`, `traits_type_kappelt`, `requiresActionTopic_kappelt`, `requiresStatusTopic_kappelt`) VALUES
(1, 0, 'Padrão', '01:AA:99:99:99:99', '000-00-000', 10, 1, 1, 1, 1, 1, 'Padrão', '', '', '', '/house/iluminacao/01AA99999999', '', '', '', '/house/iluminacao/01AA99999999', '1', '0', '', '', '', '', '', 0, 0, 0, 0, 1, 0, 2, '', '', '', 1, 0, 9073, 'Light', 'OnOff', 1, 1),
(2, 1, 'Status-Padrão', '', '', 11, 3, 0, 1, 0, 1, 'Status-Padrão', '', '', '', '/house/confirma/01AA99999999', '', '', '', '', 'On', 'Off', '', '', '20', '50', '', -16711936, 0, 0, 0, 0, 0, 0, '', '', '', 1, 0, 9073, 'Light', 'OnOff', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `widget_type`
--

CREATE TABLE `widget_type` (
  `tipo` int(11) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `codigo` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `widget_type`
--

INSERT INTO `widget_type` (`tipo`, `nome`, `descricao`, `codigo`) VALUES
(1, 'Valor', 'Valor-Ler um Dispositivo ou Sensor', 0),
(2, 'Chave (On-Off)', 'Chave (Liga-Desliga)', 1),
(3, 'Botão', 'Botão ', 2),
(4, 'Led', 'Led RGB Indicação Digital', 3),
(5, 'Dimer', 'Dimer (Variação de Corrente ou Tensão)', 4),
(6, 'Cabeçalho', 'Cabeçalho Indicação', 5),
(7, 'Medir', 'Medir Valores em escala (Ex. %)', 6),
(8, 'Grafico', 'Gratico de Valores', 7),
(9, 'Botão Set', 'Botões de controle', 8),
(10, 'Combo Box', 'Combo Box', 9);

-- --------------------------------------------------------

--
-- Estrutura para tabela `zigbee2mqtt`
--

CREATE TABLE `zigbee2mqtt` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `serialzigbee` varchar(128) NOT NULL,
  `valorzigbee` varchar(128) NOT NULL,
  `topico` varchar(128) NOT NULL,
  `valormqtt` varchar(128) NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `zigbeedevice`
--

CREATE TABLE `zigbeedevice` (
  `id` int(11) NOT NULL,
  `serialzigbee` varchar(128) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `carga` varchar(128) NOT NULL,
  `acao` varchar(12) NOT NULL DEFAULT 'NOK',
  `topico` varchar(128) NOT NULL,
  `id_widget` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos_lpr`
--

CREATE TABLE `veiculos_lpr` (
  `id` int(11) NOT NULL,
  `veiculodes` varchar(225) NOT NULL,
  `veiculoplaca` varchar(225) NOT NULL,
  `veiculoultimoacesso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `veiculohabilitado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cameralpr`
--

CREATE TABLE `cameralpr` (
  `id` int(11) NOT NULL,
  `ip_camera` varchar(36) NOT NULL,
  `senha_camera` varchar(255) NOT NULL,
  `usercamera` varchar(255) NOT NULL,
  `device_atuador_codigo` varchar(255) NOT NULL,
  `device_sensor_codigo` varchar(255) NOT NULL,
  `device_trava_codigo` varchar(255) NOT NULL,
  `valor_device_trava_codigo` varchar(255) NOT NULL DEFAULT '1',
  `delay` varchar(10) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------



--
-- Índices de tabelas apagadas
--

--
-- Estrutura para tabela `tuyaDevice`
--

CREATE TABLE `tuyaDevice` (
  `id` int(11) NOT NULL,
  `tuyaIDevice` varchar(128) NOT NULL,
  `code` varchar(255) NOT NULL,
  `value` varchar(128) NOT NULL,
  `topico` varchar(128) NOT NULL,
  `id_widget` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices de tabelas apagadas
--


--
-- Índices de tabela `alerta`
--
ALTER TABLE `alerta`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ambiente`
--
ALTER TABLE `ambiente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `associar_widget`
--
ALTER TABLE `associar_widget`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cena`
--
ALTER TABLE `cena`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `comandos_infrared`
--
ALTER TABLE `comandos_infrared`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `controle_ir`
--
ALTER TABLE `controle_ir`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `dispositivo_type`
--
ALTER TABLE `dispositivo_type`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `equipamento_infrared`
--
ALTER TABLE `equipamento_infrared`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `historico_alerta`
--
ALTER TABLE `historico_alerta`
  ADD PRIMARY KEY (`int`);

--
-- Índices de tabela `historico_mqtt`
--
ALTER TABLE `historico_mqtt`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ifttt`
--
ALTER TABLE `ifttt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `power`
--
ALTER TABLE `power`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `programacao`
--
ALTER TABLE `programacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `protocolo_infrared`
--
ALTER TABLE `protocolo_infrared`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `pushover`
--
ALTER TABLE `pushover`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `qrcode`
--
ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `rx433mhz`
--
ALTER TABLE `rx433mhz`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `rx433mhz_alarmes`
--
ALTER TABLE `rx433mhz_alarmes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `rx433mhz_garage`
--
ALTER TABLE `rx433mhz_garage`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `rx433mhz_persiana`
--
ALTER TABLE `rx433mhz_persiana`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `rx433mhz_portas`
--
ALTER TABLE `rx433mhz_portas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `rx433mhz_violacao`
--
ALTER TABLE `rx433mhz_violacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sensores_instalado`
--
ALTER TABLE `sensores_instalado`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sensoriamento`
--
ALTER TABLE `sensoriamento`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `servidor`
--
ALTER TABLE `servidor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tipo_sensor`
--
ALTER TABLE `tipo_sensor`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario_admin`
--
ALTER TABLE `usuario_admin`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario_widget`
--
ALTER TABLE `usuario_widget`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `widget`
--
ALTER TABLE `widget`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `widget_type`
--
ALTER TABLE `widget_type`
  ADD PRIMARY KEY (`tipo`);

--
-- Índices de tabela `zigbee2mqtt`
--
ALTER TABLE `zigbee2mqtt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices de tabela `zigbeedevice`
--
ALTER TABLE `zigbeedevice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- Índices de tabela `cameralpr`
--
ALTER TABLE `cameralpr`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

  
----
-- Índices de tabela `veiculos_lpr`
--
ALTER TABLE `veiculos_lpr`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

-- Índices de tabela `tuyaDevice`
--
ALTER TABLE `tuyaDevice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--


-- AUTO_INCREMENT de tabela `alerta`
--
ALTER TABLE `alerta`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ambiente`
--
ALTER TABLE `ambiente`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `associar_widget`
--
ALTER TABLE `associar_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `cena`
--
ALTER TABLE `cena`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `comandos_infrared`
--
ALTER TABLE `comandos_infrared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `controle_ir`
--
ALTER TABLE `controle_ir`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dispositivo_type`
--
ALTER TABLE `dispositivo_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `equipamento_infrared`
--
ALTER TABLE `equipamento_infrared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_alerta`
--
ALTER TABLE `historico_alerta`
  MODIFY `int` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `historico_mqtt`
--
ALTER TABLE `historico_mqtt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ifttt`
--
ALTER TABLE `ifttt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `power`
--
ALTER TABLE `power`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `programacao`
--
ALTER TABLE `programacao`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `protocolo_infrared`
--
ALTER TABLE `protocolo_infrared`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `pushover`
--
ALTER TABLE `pushover`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `qrcode`
--
ALTER TABLE `qrcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `rx433mhz`
--
ALTER TABLE `rx433mhz`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rx433mhz_alarmes`
--
ALTER TABLE `rx433mhz_alarmes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rx433mhz_garage`
--
ALTER TABLE `rx433mhz_garage`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rx433mhz_persiana`
--
ALTER TABLE `rx433mhz_persiana`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rx433mhz_portas`
--
ALTER TABLE `rx433mhz_portas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rx433mhz_violacao`
--
ALTER TABLE `rx433mhz_violacao`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sensores_instalado`
--
ALTER TABLE `sensores_instalado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sensoriamento`
--
ALTER TABLE `sensoriamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `servidor`
--
ALTER TABLE `servidor`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_sensor`
--
ALTER TABLE `tipo_sensor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `usuario_admin`
--
ALTER TABLE `usuario_admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_widget`
--
ALTER TABLE `usuario_widget`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `widget`
--
ALTER TABLE `widget`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `widget_type`
--
ALTER TABLE `widget_type`
  MODIFY `tipo` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `zigbee2mqtt`
--
ALTER TABLE `zigbee2mqtt`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `zigbeedevice`
--
ALTER TABLE `zigbeedevice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

  --
-- AUTO_INCREMENT de tabela `cameralpr`
--
ALTER TABLE `cameralpr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `veiculos_lpr`
--

ALTER TABLE `veiculos_lpr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de tabela `tuyaDevice`
--
ALTER TABLE `tuyaDevice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;


COMMIT;

--
-- CONFIGURA ACEITAR VAZIO
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

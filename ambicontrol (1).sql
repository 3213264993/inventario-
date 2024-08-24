-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-08-2024 a las 04:50:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ambicontrol`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id` int(11) NOT NULL,
  `Numero_documento` varchar(50) NOT NULL,
  `Tipo_asignacion` enum('Entrada','Salida') NOT NULL,
  `Numero_ambiente` varchar(50) NOT NULL,
  `Fecha` date NOT NULL DEFAULT curdate(),
  `Hora` time NOT NULL DEFAULT curtime(),
  `Fecha_Hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id`, `Numero_documento`, `Tipo_asignacion`, `Numero_ambiente`, `Fecha`, `Hora`, `Fecha_Hora`) VALUES
(1, '1072421404', 'Salida', 'ambiente9', '2024-08-12', '17:00:09', '2024-08-13 00:00:09'),
(2, '1072421404', 'Salida', '101', '2024-08-12', '19:04:53', '2024-08-13 02:04:53'),
(9, '1072421404', 'Entrada', 'ambiente5', '2024-08-20', '16:23:19', '2024-08-20 23:23:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `elemento` varchar(255) DEFAULT NULL,
  `disponibilidad` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `hora` time DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Elemento` varchar(255) NOT NULL,
  `Disponibilidad` enum('sí','no') NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `descripción` varchar(255) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `Fecha_Hora` datetime DEFAULT NULL,
  `Numero_Documento` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `Fecha`, `Hora`, `Elemento`, `Disponibilidad`, `Cantidad`, `descripción`, `descripcion`, `Fecha_Hora`, `Numero_Documento`) VALUES
(1239, '2024-08-24', '04:38:23', 'Monitores', 'sí', 2, NULL, '', NULL, '1072421404'),
(1240, '2024-08-24', '04:38:23', 'Torres', 'no', 0, NULL, '', NULL, '1072421404'),
(1241, '2024-08-24', '04:38:23', 'Teclados', 'sí', 22, NULL, '', NULL, '1072421404'),
(1242, '2024-08-24', '04:38:23', 'Mouses', 'sí', 22, NULL, '', NULL, '1072421404'),
(1243, '2024-08-24', '04:38:23', 'Sillas', 'sí', 29, NULL, '', NULL, '1072421404'),
(1244, '2024-08-24', '04:38:23', 'Mesas', 'sí', 5, NULL, '', NULL, '1072421404'),
(1245, '2024-08-24', '04:38:23', 'Tablero', 'sí', 1, NULL, '', NULL, '1072421404');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observaciones`
--

CREATE TABLE `observaciones` (
  `id` int(11) NOT NULL,
  `Numero_documento` varchar(50) NOT NULL,
  `Observacion` text NOT NULL,
  `Fecha` date NOT NULL DEFAULT curdate(),
  `Hora` time NOT NULL DEFAULT curtime(),
  `Fecha_Hora` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `observaciones`
--

INSERT INTO `observaciones` (`id`, `Numero_documento`, `Observacion`, `Fecha`, `Hora`, `Fecha_Hora`) VALUES
(1, '1072421404', 'salón demasiado sucio', '2024-08-12', '14:06:42', '2024-08-12 21:06:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password`
--

CREATE TABLE `password` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `password`
--

INSERT INTO `password` (`id`, `email`, `token`, `expires`) VALUES
(1, 'karenbohorquez@gmail.com', 'c499cf08786af24f3b2664fd97c1ac4057dd71de8c7e0aae3c180f4edede0e003cf6fb3a84e741cb7f94d7fef9b2cbc3ddb0', '2024-08-14 22:19:35'),
(2, 'karenbohorquez@gmail.com', '802271fa2c7c24e3e5fc0b9c631fe384eb9540fff67962da1070bf28579980d8ec7930ca7a0b81c08038c9474c115197b3f6', '2024-08-14 22:41:50'),
(3, 'karenbohorquez@gmail.com', 'cc6f78c69fe9bde9b231c3d82eb1f7816fbc4c483461f780f6d7c94b87fd6070cd07fc51589abeea7d966168444d7681d172', '2024-08-14 22:41:57'),
(4, 'yclopez10724@gmail.com', 'e7db7e59b1b5fb373b1ec2c73e7531ba3262ba801e5e316682ca71678162a2a14680f38b67e3fd0734b9fdd346fcb12029c6', '2024-08-14 22:42:42'),
(5, 'yclopez10724@gmail.com', 'df693f3d53fafb7e3f63624390c9b74b35592c5f4b8141297a2a92d25da33d5dd65fffadb3a262cbb6b74416b92ac4416bd2', '2024-08-14 22:44:34'),
(6, 'yclopez10724@gmail.com', '22eda7a604992419d00c84e1302b9a07de6103ee6cab32ba18956d693960b790c8008d95b7f159fabde6488a770864e3d1c9', '2024-08-14 22:45:49'),
(7, 'yclopez10724@gmail.com', '7e38faaef705b57af1ec0d1c46ea599b6bbdcc384e3ff0c65f52e9fba981a220b30c1c21d1960b9daa6613c5ea667e8fba54', '2024-08-14 23:58:27'),
(8, 'yclopez10724@gmail.com', '987c200ae09cfd8778faa77c7dcb64ff8557249bb533e02d81c9cf51a850a85a693570921eae8c3cfc8a5742ad1971fe865d', '2024-08-14 23:59:45'),
(9, 'yclopez10724@gmail.com', '72480a7ab14dbc19e66e69fd3df7845236a5d4dfeb2501a3a6f4409d457c00640dd5c06601093c0b7c118186b0170e011938', '2024-08-15 00:00:00'),
(10, 'yclopez10724@gmail.com', 'd6a3eb6762249bb58eafa914e5a51b09765c6bac0f78a57215ff1b791624a32ef2905ee37a72746e78cd9ae9a9016d61cdcb', '2024-08-15 00:02:51'),
(11, 'yclopez10724@gmail.com', '8ea151ae0eeda5e76795b2ef6172973a0a2b816543c395bbfe2ecaa452bd46ec2b9a0a9f027a43dce3e44d74f66b232b654a', '2024-08-15 00:03:23'),
(12, 'yclopez10724@gmail.com', 'a62b413d233ac5601bd841b1cd5a8d94cdd241a4856527be4c2b09a44291d9c418b6c979efae87e06fab5235b6048e3ed22b', '2024-08-15 00:08:28'),
(13, 'yclopez10724@gmail.com', '46ee68468d095bdb6cb1660a3dd0f421e54798519974e507366012ddf3d435f1f721af7d31d3331985270d41069e4b3e15d6', '2024-08-15 00:30:45'),
(14, 'yclopez10724@gmail.com', '5b5107c055617dfaa533ed91679d50c78d27404bc104030d9004d0a2a31509b5828aef45e6e416a4a22e83fbf42f23d8e09c', '2024-08-15 00:31:33'),
(15, 'yclopez10724@gmail.com', '21a47381994968577b0bb7bd66398f7a342d9a1a5d3914e4782ca3229cdad877fa8f4f38e0214beeb363d68789e9573e6c36', '2024-08-15 00:31:38'),
(16, 'yclopez10724@gmail.com', 'a8fd3706713c6ca12daabab0eb95683943dc25522e79fb6c1c323847ff3f3d6594028e0e362377db0ca9c67485353d8c982a', '2024-08-15 00:37:38'),
(17, 'yclopez10724@gmail.com', 'e33e06c71b8473160eac18a064a92a0ad0352e2d27b2f85c52347065a4865adf589ba26023780e0a0703a05153f5b4533eea', '2024-08-15 00:38:35'),
(18, 'yclopez10724@gmail.com', '7893df100343af29b9fd6025666d70acdf297075f9d15d2d5e98c8ea71813250acc84ffb83e7cfe41535f8e3adfda996da44', '2024-08-15 00:38:53'),
(19, 'yclopez10724@gmail.com', 'bca0f84030047a70bf15450159bca515fde92986ca40d15c585535032384cd235872145bdc4720ea2e75b2af51cc9b1a4944', '2024-08-21 23:55:57');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `Nombre_completo` text NOT NULL,
  `Email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `Tipo_documento` enum('CC','TI','PP') NOT NULL,
  `Numero_documento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `Nombre_completo`, `Email`, `password`, `Tipo_documento`, `Numero_documento`) VALUES
(7, 'yeni catalina lopez ', 'yclopez10724@gmail.com', '1072421404', 'CC', '1072421404'),
(11, 'Angelica maria cifuentes', 'angelgabriel542@gmail.com', 'angelica', 'CC', '52663277'),
(14, 'karen bohorquez', 'karenbohorquez@gmail.com', '123456', 'CC', '1004006640'),
(16, 'hola', 'marlenilopez@gmail.com', '90909090', 'CC', '1004065662'),
(17, 'angie lopez contreras', 'aylopez9679@gmail.com', '234567', 'CC', '1193519679'),
(19, 'karen lopez ', 'tatislopez@gmail.com', '987654321', 'CC', '1007155682');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Numero_documento` (`Numero_documento`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Numero_documento` (`Numero_documento`);

--
-- Indices de la tabla `password`
--
ALTER TABLE `password`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `Numero_documento` (`Numero_documento`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1246;

--
-- AUTO_INCREMENT de la tabla `observaciones`
--
ALTER TABLE `observaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `password`
--
ALTER TABLE `password`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`Numero_documento`) REFERENCES `usuarios` (`Numero_documento`);

--
-- Filtros para la tabla `observaciones`
--
ALTER TABLE `observaciones`
  ADD CONSTRAINT `observaciones_ibfk_1` FOREIGN KEY (`Numero_documento`) REFERENCES `usuarios` (`Numero_documento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

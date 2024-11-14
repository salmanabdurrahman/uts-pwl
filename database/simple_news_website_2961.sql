-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2024 pada 16.47
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple_news_website_2961`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `short_description` text NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `short_description`, `content`, `image_url`, `created_at`, `created_by`) VALUES
(9, 'The Impact of Artificial Intelligence on Global Politics', 'Examining how AI is reshaping decision-making in global politics', 'Artificial intelligence is rapidly influencing global political landscapes. From optimizing resource management to enhancing cybersecurity, AI-driven decisions are transforming governmental processes. Countries are investing in AI to gain a competitive advantage, but this rush also raises ethical and security concerns. The balance between power and privacy is delicate, and as nations deploy AI in defense, healthcare, and urban planning, public trust in these innovations becomes crucial.', '../assets/uploads/ai-7977960_640.jpg', '2024-11-11 17:39:26', 3),
(10, 'Cryptocurrencies and the Future of Finance', 'Understanding how cryptocurrencies are changing traditional finance', 'Cryptocurrencies like Bitcoin and Ethereum have revolutionized finance by offering decentralized and borderless transactions. Blockchain technology ensures transparency and security, but regulatory challenges persist. As governments evaluate crypto&#039;s economic impact, many are working toward clearer regulatory frameworks. The future of finance may be a blend of traditional banking and digital assets.', '../assets/uploads/bitcoin-3773583_640.jpg', '2024-11-11 17:40:11', 3),
(11, 'Climate Action: The Role of Corporations in Reducing Carbon Emissions', 'How corporations are stepping up to combat climate change', 'With the climate crisis becoming increasingly urgent, corporations are under pressure to reduce their carbon footprint. Companies are setting ambitious targets to become carbon-neutral, investing in green technologies, and adopting sustainable practices. This shift is not only driven by environmental concerns but also by consumer demand for eco-friendly brands. Collaborative efforts between governments and businesses are essential to achieving significant climate goals.', '../assets/uploads/pollution-4796858_640.jpg', '2024-11-11 17:40:43', 3),
(12, 'The Rise of E-Commerce in Emerging Markets', 'Exploring the e-commerce boom in developing economies', 'E-commerce has surged in emerging markets, fueled by increasing internet access and smartphone usage. Companies like Amazon and Alibaba are investing in infrastructure to reach these markets, while local businesses are also thriving online. However, logistical challenges and varying consumer behaviors pose unique challenges. As these economies grow, e-commerce will play a vital role in shaping their economic landscape.', '../assets/uploads/online-6817350_640.jpg', '2024-11-11 17:41:09', 3),
(13, '5G and Its Potential to Revolutionize Business Operations', 'Understanding how 5G technology will transform businesses', '5G technology promises faster speeds and more reliable internet, transforming industries from healthcare to manufacturing. Companies can leverage 5G to improve remote work, enhance IoT solutions, and streamline operations. With 5G&#039;s high-speed connectivity, businesses are better positioned to adopt cutting-edge technologies, pushing productivity and innovation.', '../assets/uploads/samsung-4721549_640.jpg', '2024-11-11 17:41:34', 3),
(14, 'Global Supply Chain Disruptions and Business Resilience', 'How businesses can navigate supply chain challenges', 'Global supply chain disruptions have highlighted the need for resilience in business. Factors such as the pandemic, geopolitical tensions, and natural disasters have impacted supplies worldwide. Companies are now investing in supply chain diversification and digital solutions to mitigate risks. Business resilience strategies are crucial for maintaining operations amidst uncertainty.', '../assets/uploads/budapest-2173057_640.jpg', '2024-11-11 17:46:36', 4),
(15, 'The Role of Social Media in Modern Politics', 'Analyzing social media&#039;s influence on political discourse', 'Social media platforms have become powerful tools in modern politics, offering politicians direct communication channels with constituents. However, misinformation and polarization are growing concerns. Platforms are implementing content regulation policies, but balancing free speech with responsible discourse remains challenging. Social media will continue to shape political landscapes, influencing public opinion and mobilization.', '../assets/uploads/media-998990_640.jpg', '2024-11-11 17:47:06', 4),
(16, 'Fintech: The New Wave in Financial Inclusion', 'How fintech is bringing financial services to the unbanked', 'Fintech companies are providing financial services to previously underserved populations. With mobile banking, micro-lending, and digital payment solutions, fintech is empowering individuals and small businesses in developing economies. This innovation fosters economic growth and reduces the global gap in financial inclusion.', '../assets/uploads/skyscraper-3251510_640.jpg', '2024-11-11 17:47:47', 4),
(17, 'The Future of Remote Work in a Post-Pandemic World', 'Exploring remote work trends and their impact on businesses', 'Remote work has reshaped corporate culture and productivity. Companies are adopting hybrid work models, allowing employees flexibility. This shift has led to increased productivity and employee satisfaction but presents challenges like maintaining company culture and data security. The future of work may be a flexible mix of remote and on-site setups.', '../assets/uploads/man-4749237_640.jpg', '2024-11-11 17:48:11', 4),
(18, 'Electric Vehicles: A Step Towards Sustainable Transportation', 'The rise of electric vehicles and their environmental impact', 'Electric vehicles (EVs) are gaining popularity as governments push for cleaner transportation. EVs reduce carbon emissions and dependence on fossil fuels. With advances in battery technology and increased charging infrastructure, EVs are becoming more accessible. However, challenges like battery disposal and initial costs remain. EVs are a crucial component in the shift to sustainable transportation.', '../assets/uploads/e-scooter-5403696_640.jpg', '2024-11-11 17:48:28', 4),
(19, 'The Power and Pitfalls of Big Data in Business', 'Big data&#039;s role in transforming business decisions.', 'Big data offers businesses unprecedented insights into customer behavior, operational efficiencies, and market trends. By analyzing massive datasets, companies can make data-driven decisions to improve products and customer experiences. However, big data poses privacy concerns, making transparent data practices essential to maintaining customer trust.', '../assets/uploads/circuit-board-2440249_640.jpg', '2024-11-11 17:53:06', 8),
(20, 'Green Technology in Urban Development', 'Sustainable solutions for the cities of the future', 'Green technology is crucial for sustainable urban development. From green buildings to efficient waste management, cities are adopting eco-friendly practices. Solar power, rainwater harvesting, and electric public transport are part of this green shift. Green tech offers environmental benefits and fosters economic growth by creating green jobs.', '../assets/uploads/urban-2138802_640.jpg', '2024-11-11 17:53:33', 8),
(21, 'The Influence of Blockchain on Voting Systems', 'Can blockchain secure the future of voting?', 'Blockchain technology promises a secure and transparent voting system. By decentralizing vote counts and ensuring data integrity, blockchain could minimize election fraud. However, technical challenges and public trust issues persist. Governments are piloting blockchain voting, but full-scale implementation requires significant infrastructure and public buy-in.', '../assets/uploads/blockchain-3055701_640.jpg', '2024-11-11 17:54:04', 8),
(22, 'The Challenge of Digital Privacy in the Age of Surveillance', 'Exploring digital privacy concerns and surveillance issues', 'In a world where data collection is rampant, digital privacy has become a major concern. Surveillance technologies are widely used in policing, business, and everyday devices. Balancing security with privacy rights is essential, as governments and organizations navigate regulations to protect individuals.', '../assets/uploads/hands-820272_640.jpg', '2024-11-11 18:01:02', 12),
(23, 'The Future of Renewable Energy Investments', 'Analyzing trends in renewable energy financing', 'Renewable energy investments are booming as countries seek to reduce reliance on fossil fuels. Wind, solar, and hydro energy are at the forefront of this transition. Investment incentives and policies are encouraging the private sector to participate in clean energy projects. The future of energy is sustainable, but achieving global carbon neutrality requires continued innovation.', '../assets/uploads/biomass-heating-power-plant-910240_640.jpg', '2024-11-11 18:01:46', 12),
(24, 'Machine Learning in Personalized Healthcare', 'How machine learning is transforming healthcare', 'Machine learning is enabling personalized healthcare by analyzing patient data to create tailored treatment plans. This technology improves diagnosis accuracy and offers new treatment insights. However, data security and ethical issues must be addressed to ensure patient privacy and equitable access to AI-driven healthcare.', '../assets/uploads/to-learn-4338935_640.jpg', '2024-11-11 18:02:04', 12),
(25, 'Quantum Computing: The Next Technological Revolution', 'What quantum computing means for the future', 'Quantum computing holds promise for industries from pharmaceuticals to logistics by solving complex problems at unprecedented speeds. While still in its infancy, companies and governments are investing in quantum research. The technology could revolutionize problem-solving but also raises concerns about security and ethical usage.', '../assets/uploads/quantum-computer-3679893_640.jpg', '2024-11-11 18:04:52', 13),
(26, 'The Global Shift to Remote Healthcare Solutions', 'The rise of telemedicine and digital healthcare', 'Telemedicine has expanded healthcare access, especially in remote areas. Digital consultations and remote monitoring are helping manage healthcare costs and improve patient outcomes. As telemedicine becomes mainstream, ensuring data privacy and equitable access is essential.', '../assets/uploads/laboratory-563423_640.jpg', '2024-11-11 18:05:19', 13),
(27, 'Augmented Reality in Education: A New Learning Experience', 'Exploring AR&#039;s potential in transforming education', 'Augmented reality (AR) enhances learning by creating immersive experiences. AR applications allow students to visualize complex concepts interactively. Schools and universities are experimenting with AR to make education more engaging. AR in education promises a more dynamic, personalized learning experience.', '../assets/uploads/woman-1845517_640.jpg', '2024-11-11 18:07:54', 14),
(28, 'Climate Resilience: Preparing Cities for Extreme Weather', 'How cities are adapting to climate-related risks', 'As extreme weather events become more frequent, cities are investing in climate resilience. From flood defenses to heat-resistant infrastructure, urban planners are developing systems to mitigate climate risks. Climate resilience involves cooperation between governments, businesses, and communities to ensure long-term urban sustainability.', '../assets/uploads/castle-8033915_640.jpg', '2024-11-11 18:08:17', 14),
(32, 'Testing for updating content', 'Testing for updating content', 'Testing for updating content', '../assets/uploads/network-6926764_640.jpg', '2024-11-12 13:58:43', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `contacted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `contact`
--

INSERT INTO `contact` (`contact_id`, `firstname`, `lastname`, `email`, `phone_number`, `details`, `contacted_at`) VALUES
(4, 'Salman', 'Abdurrahman', 'salman@gmail.com', '0812123456789', 'Testing', '2024-11-11 18:31:52'),
(5, 'Aji', 'Nomoto', 'ajinomoto@gmail.com', '123', 'Good job dude 🔥', '2024-11-14 15:39:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subscribe`
--

CREATE TABLE `subscribe` (
  `subscribe_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subscribed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `subscribe`
--

INSERT INTO `subscribe` (`subscribe_id`, `email`, `subscribed_at`) VALUES
(1, 'tes@gmail.com', '2024-11-09 21:04:21'),
(2, 'salman@gmail.com', '2024-11-09 21:06:24'),
(3, 'joko@gmail.com', '2024-11-13 14:11:52'),
(4, 'sa@gmail.com', '2024-11-13 14:12:56'),
(5, 'jajang@gmail.com', '2024-11-13 14:20:01'),
(6, 'ajinomoto@gmail.com', '2024-11-14 15:40:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `full_name`, `email`, `password`, `role`, `created_at`, `gender`) VALUES
(3, 'salmanabd', 'Salman Abdurrahman', 'salman@gmail.com', '123', 'admin', '2024-11-04 11:22:12', 'male'),
(4, 'admin', 'Admin', 'admin@gmail.com', 'admin', 'admin', '2024-11-04 11:22:12', 'female'),
(8, 'sigit', 'Sigit Rendang', 'sigit@gmail.com', '123', 'user', '2024-11-05 11:17:32', 'male'),
(12, 'hitler', 'Adolf Hitler', 'hitlergarut@gmail.com', '123', 'user', '2024-11-10 12:47:50', 'male'),
(13, 'asep', 'Asep Bensin', 'asep@gmail.com', '123', 'user', '2024-11-11 18:03:37', 'male'),
(14, 'cecep', 'Cecep Surahman', 'cecep@gmail.com', '123', 'user', '2024-11-11 18:07:17', 'male'),
(16, 'testing', 'Testing', 'testing@gmail.com', '123', 'user', '2024-11-12 13:58:03', 'female');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indeks untuk tabel `subscribe`
--
ALTER TABLE `subscribe`
  ADD PRIMARY KEY (`subscribe_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `subscribe`
--
ALTER TABLE `subscribe`
  MODIFY `subscribe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

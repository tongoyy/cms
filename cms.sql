
INSERT INTO `purchase_order_items` (`id`, `Purchase_Orders_ID`, `Item_Name`, `Item_Description`, `Quantity`, `Price`, `Unit`, `Tax`, `Tax_Amount`, `Discount`, `Total`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'VPS', 'Server', 12, 185000, 'Bulan', 'None', 0, NULL, 2486400, '2025-03-12 21:46:11', '2025-03-12 21:46:11'),
	(2, NULL, 'VPN', 'VPN', 12, 55000, 'Bulan', 'None', 0, NULL, 660000, '2025-03-12 21:46:11', '2025-03-12 21:46:11');

-- Dumping data for table cms.purchase_requests: ~2 rows (approximately)
INSERT INTO `purchase_requests` (`id`, `PR_Code`, `Purchase_Requests_ID`, `Number`, `PR_Name`, `Project`, `Department`, `PurchaseType`, `Category`, `DueDate`, `Description`, `SubTotal`, `GrandTotal`, `created_at`, `updated_at`) VALUES
	(3, '#PR-00002-2025-OPERATION', NULL, 2, 'Mobil Operasional Maret 2025', 'Zona 4', 'Operation', 'Jasa', 'Project', '2025-03-13 06:53:13', 'Pembayaran mobil operasional di zona 4 (Limau) periode Maret 2025', '21500000', '21500000', '2025-03-12 23:58:26', '2025-03-12 23:58:26'),
	(7, '#PR-00003-2025-OPERATION', NULL, 3, 'Utilities Kantor Jakarta & Cibitung (3 Bulan)', 'Zona 4', 'Operation', 'Jasa', 'Operasional Kantor', '2025-04-15 08:54:00', 'Utilities Kantor Jakarta (Listrik, air, internet & telpon) & Cibitung (Internet)', '13500000', '13500000', '2025-04-15 01:55:48', '2025-04-15 01:56:04');

-- Dumping data for table cms.purchase_request_items: ~10 rows (approximately)
INSERT INTO `purchase_request_items` (`id`, `Purchase_Requests_ID`, `Item_Name`, `Item_Description`, `Quantity`, `Price`, `Unit`, `Tax`, `Tax_Amount`, `Total`, `created_at`, `updated_at`) VALUES
	(1, NULL, 'VPS', 'Server', 12, 185000, 'Bulan', 'PPN', 266400, 2486400, '2025-03-12 21:33:42', '2025-03-12 21:33:42'),
	(2, NULL, 'VPN', 'VPN', 12, 55000, 'Bulan', 'Tanpa Pajak', 0, 660000, '2025-03-12 21:33:42', '2025-03-12 21:33:42'),
	(3, 3, 'Periode Maret', 'Mobil Operasional', 1, 21500000, 'Ls', 'Tanpa Pajak', 0, 21500000, '2025-03-12 23:58:26', '2025-03-12 23:58:26'),
	(4, NULL, 'Test', 'Test', 2, 250000, 'pcs', NULL, NULL, 500000, '2025-03-20 00:50:07', '2025-03-20 00:50:07'),
	(5, NULL, 'Item', 'Item', 2, 25000, 'pcs', NULL, NULL, 50000, '2025-03-20 01:54:12', '2025-03-20 01:54:12'),
	(6, NULL, 'Item 2 ', 'Item 2', 5, 55000, 'pcs', NULL, NULL, 275000, '2025-03-20 01:54:12', '2025-03-20 01:54:12'),
	(7, NULL, '1', '1', 25, 2, 'pcs', NULL, NULL, 50000, '2025-04-06 22:49:25', '2025-04-06 22:49:25'),
	(8, NULL, '1', NULL, 2, 25, 'pcs', NULL, NULL, 50000, '2025-04-06 22:50:55', '2025-04-06 22:50:55'),
	(9, NULL, 'test', NULL, 1, 1500000, 'pcs', NULL, NULL, 1500000, '2025-04-15 00:06:41', '2025-04-15 00:06:41'),
	(10, 7, 'Pembayaran 1 Bulan', NULL, 3, 4500000, 'Bulan', NULL, NULL, 13500000, '2025-04-15 01:55:48', '2025-04-15 01:55:48');

-- Dumping data for table cms.sp3s: ~2 rows (approximately)
INSERT INTO `sp3s` (`id`, `Purchase_Requests_ID`, `Purchase_Orders_ID`, `Vendors_ID`, `SP3_Number`, `Number`, `Purchase_Request`, `Purchase_Order`, `Vendors`, `Date_Created`, `Nama_Supplier`, `No_Invoice`, `Tanggal_Invoice`, `No_Kwitansi`, `Tanggal_Kwitansi`, `No_DO`, `Tanggal_DO`, `No_FP`, `Tanggal_FP`, `Jenis_Pembayaran`, `Untuk_Pembayaran`, `Rekening_Bank`, `Nomor_Rekening`, `Atas_Nama`, `Lokasi`, `Paid_Status`, `Amount`, `PPN`, `PPH`, `Discount`, `Jumlah`, `Terbilang`, `created_at`, `updated_at`) VALUES
	(3, NULL, NULL, 2, '00003/AMI-SP3/03/2025-VC-002', '3', '3', NULL, '2', '2025-03-13', 'PT. TRIJAYA ARTHA SUKSES', 'TAS/INV/03/III/2025', '2025-03-13', '0000', '2025-03-13', '00001', '2025-03-13', '0000', '2025-03-13', 'Full Payment', 'Pembayaran mobil operasional di zona 4 (Limau) periode Maret 2025', 'BCA', 750204929, 'PT. TRIJAYA ARTHA SUKSES', 'Limau', 'Unpaid', 21500000, 0, 0, 0, 21500000, 'Dua Puluh Satu Juta Lima Ratus Ribu Rupiah', '2025-03-13 00:24:08', '2025-04-15 02:01:18'),
	(4, NULL, NULL, 3, '00004/AMI-SP3/04/2025-VC-003', '4', '7', NULL, '3', '2025-04-15', 'Mochamad Irvan Sandoval', NULL, '2025-04-15', '0', '2025-04-15', '0', '2025-04-15', '0', '2025-04-15', 'Full Payment', 'Utilities Kantor Jakarta (Listrik, air, internet & telpon) & Cibitung (Internet) 3 Bulan kedepan', 'Mandiri', 1030006931402, 'TOKOPEDIA', 'Jakarta', 'Unpaid', 13500000, 0, 0, 0, 13500000, 'Tiga Belas Juta Lima Ratus Ribu Rupiah', '2025-04-15 02:02:04', '2025-04-15 22:41:49');

-- Dumping data for table cms.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Administrator', 'admin@audemars.co.id', NULL, '$2y$12$pz8GMeWld9XNVdsl8R5Mz.o1nJPnMuGp45nC3aZIADH6Kf4sFC4gu', 'zSchcfFfiBmcyXgK2n0kkjL7chiLQ1KHnFNIlf2nOUpa3aO6Bzgk0k1juvax', '2025-03-12 21:32:12', '2025-03-12 21:32:12');

-- Dumping data for table cms.vendors: ~2 rows (approximately)
INSERT INTO `vendors` (`id`, `Number`, `VendorCode`, `CompanyName`, `NPWP`, `Phone`, `Email`, `Address`, `RekeningBank`, `NomorRekening`, `created_at`, `updated_at`) VALUES
	(2, 2, 'VC-002', 'PT. TRIJAYA ARTHA SUKSES', '0000000000000', '02150996969', 'admin@TRIJAYA.com', 'Gedung Wirausaha Lantai 1 Unit 104 Jl. HR Rasuna Said Kav. C-5', 'BCA', '0750204929', '2025-03-13 00:02:05', '2025-03-13 00:02:05'),
	(3, 3, 'VC-003', 'TOKOPEDIA', NULL, '085166903811', NULL, 'Tokopedia Tower Ciputra World 2, Jl. Prof. DR. Satrio No.Kav. 11, RT.3/RW.3, Karet Semanggi, Setiabudi, South Jakarta City, Jakarta 12950', 'Mandiri', '1030006931402', '2025-04-15 01:57:26', '2025-04-15 01:57:26');
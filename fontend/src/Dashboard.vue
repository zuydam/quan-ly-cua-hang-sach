<template>
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50">
        <!-- Header -->
        <header class="bg-white shadow-lg border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div class="flex items-center space-x-4">
                        <div class="p-2 bg-gradient-to-r from-green-600 to-emerald-600 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                QLS - Hệ thống Quản lý Sách
                            </h1>
                            <p class="text-sm text-gray-600">Quản lý cửa hàng sách chuyên nghiệp</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">{{ currentDate }}</div>
                            <div class="text-xs text-gray-500">{{ currentTime }}</div>
                        </div>
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">QLS</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation Tabs -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex space-x-1">
                    <button 
                        @click="activeTab = 'dashboard'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'dashboard' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </button>
                    <button 
                        @click="activeTab = 'books'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'books' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span>Quản lý Sách</span>
                    </button>
                    <button 
                        @click="activeTab = 'customers'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'customers' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Khách hàng</span>
                    </button>
                    <button 
                        @click="activeTab = 'orders'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'orders' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Đơn hàng</span>
                    </button>
                    <button 
                        @click="activeTab = 'orderDetails'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'orderDetails' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <span>Chi tiết đơn hàng</span>
                    </button>
                    <button 
                        @click="activeTab = 'suppliers'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'suppliers' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>Nhà cung cấp</span>
                    </button>
                    <button 
                        @click="activeTab = 'promotions'"
                        :class="[
                            'flex items-center space-x-2 py-4 px-6 rounded-t-lg font-medium text-sm transition-all duration-200',
                            activeTab === 'promotions' 
                                ? 'bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-lg' 
                                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
                        ]"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span>Khuyến mãi</span>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Dashboard Tab -->
            <div v-if="activeTab === 'dashboard'" class="space-y-8">
                <!-- Welcome Section -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl shadow-xl p-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Chào mừng đến với QLS</h2>
                            <p class="text-green-100 text-lg">Hệ thống quản lý sách thông minh và chuyên nghiệp</p>
                            <div class="mt-4 flex items-center space-x-4 text-sm">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Quản lý sách hiệu quả
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Báo cáo chi tiết
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Giao diện thân thiện
                                </span>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <div class="w-32 h-32 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KPI Dashboard - Key Performance Indicators -->
                <div class="space-y-6">
                    <!-- Section Header -->
                        <div class="flex items-center justify-between">
                            <div>
                            <h2 class="text-2xl font-bold text-gray-900">📊 Chỉ Số KPI Chính</h2>
                            <p class="text-gray-600">Tổng quan hiệu suất kinh doanh</p>
                            </div>
                        <div class="flex space-x-2">
                            <button @click="refreshData" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Làm mới</span>
                            </button>
                        </div>
                    </div>

                    <!-- KPI Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Revenue KPI -->
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                            <div>
                                        <p class="text-sm opacity-90">Tổng Doanh Thu</p>
                                        <p class="text-3xl font-bold">{{ formatCurrency(stats.overview?.TotalRevenue || 0) }}</p>
                            </div>
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span>Tháng này: {{ formatCurrency(stats.overview?.RevenueThisMonth || 0) }}</span>
                                    <span class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">+12%</span>
                            </div>
                        </div>
                    </div>

                        <!-- Orders KPI -->
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                            <div>
                                        <p class="text-sm opacity-90">Tổng Đơn Hàng</p>
                                        <p class="text-3xl font-bold">{{ stats.overview?.TotalOrders || 0 }}</p>
                            </div>
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span>Tháng này: {{ stats.overview?.OrdersThisMonth || 0 }}</span>
                                    <span class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">+8%</span>
                            </div>
                        </div>
                    </div>

                        <!-- Books KPI -->
                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                            <div>
                                        <p class="text-sm opacity-90">Tổng Sách</p>
                                        <p class="text-3xl font-bold">{{ stats.overview?.TotalBooks || 0 }}</p>
                            </div>
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span>Giá trị: {{ formatCurrency(stats.overview?.InventoryValue || 0) }}</span>
                                    <span class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">+5%</span>
                        </div>
                    </div>
                </div>

                        <!-- Customers KPI -->
                        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl shadow-lg p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-10 -mt-10"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <p class="text-sm opacity-90">Khách Hàng</p>
                                        <p class="text-3xl font-bold">{{ stats.overview?.TotalCustomers || 0 }}</p>
                                    </div>
                                    <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span>Hoạt động: {{ stats.overview?.ActiveCustomers || 0 }}</span>
                                    <span class="bg-white bg-opacity-20 px-2 py-1 rounded-full text-xs">+15%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory & Operations Management -->
                <div class="space-y-6">
                    <!-- Section Header -->
                        <div class="flex items-center justify-between">
                            <div>
                            <h2 class="text-2xl font-bold text-gray-900">📦 Quản Lý Tồn Kho & Vận Hành</h2>
                            <p class="text-gray-600">Theo dõi tình trạng tồn kho và hiệu suất vận hành</p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="activeTab = 'books'" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span>Quản lý sách</span>
                            </button>
                        </div>
                    </div>

                    <!-- Inventory Status Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Stock Alert -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">⚠️ Cảnh Báo Tồn Kho</p>
                                <p class="text-3xl font-bold text-red-600">{{ stats.overview?.LowStockBooks || 0 }}</p>
                                    <p class="text-xs text-red-600 mt-1">Sách cần nhập hàng</p>
                            </div>
                            <div class="p-4 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                            <div class="bg-red-50 rounded-lg p-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-red-700">Tỷ lệ tồn kho thấp</span>
                                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">
                                        {{ stats.overview?.TotalBooks > 0 ? Math.round((stats.overview?.LowStockBooks / stats.overview?.TotalBooks) * 100) : 0 }}%
                                    </span>
                            </div>
                        </div>
                    </div>

                        <!-- Total Stock -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                            <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">📚 Tổng Tồn Kho</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ stats.overview?.TotalStock || 0 }}</p>
                                    <p class="text-xs text-green-600 mt-1">Số lượng sách hiện có</p>
                            </div>
                                <div class="p-4 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                            <div class="bg-green-50 rounded-lg p-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-green-700">Giá trị tồn kho</span>
                                    <span class="text-green-800 font-semibold">{{ formatCurrency(stats.overview?.InventoryValue || 0) }}</span>
                            </div>
                        </div>
                    </div>

                        <!-- Average Price -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                            <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">💰 Giá Trung Bình</p>
                                <p class="text-3xl font-bold text-gray-900">{{ formatCurrency(stats.inventoryStats?.AveragePrice || 0) }}</p>
                                    <p class="text-xs text-blue-600 mt-1">Giá sách trung bình</p>
                            </div>
                                <div class="p-4 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                            <div class="bg-blue-50 rounded-lg p-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-blue-700">Phạm vi giá</span>
                                    <span class="text-blue-800 font-semibold">Đa dạng</span>
                            </div>
                        </div>
                    </div>

                        <!-- Suppliers -->
                        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                            <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">🏢 Nhà Cung Cấp</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ stats.overview?.TotalSuppliers || 0 }}</p>
                                    <p class="text-xs text-purple-600 mt-1">Đối tác kinh doanh</p>
                            </div>
                                <div class="p-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                </div>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-purple-700">Đối tác chính</span>
                                    <span class="text-purple-800 font-semibold">{{ stats.overview?.TotalSuppliers > 0 ? 'Đang hợp tác' : 'Chưa có' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Intelligence & Analytics -->
                <div class="space-y-8">
                    <!-- Section Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">📈 Phân Tích Kinh Doanh & Báo Cáo</h2>
                            <p class="text-gray-600">Thống kê chi tiết và phân tích xu hướng kinh doanh</p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="exportReport" class="px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Xuất báo cáo</span>
                            </button>
                        </div>
                    </div>

                    <!-- Performance Analytics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Top Selling Books -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">📊 Top Sách Bán Chạy</h3>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        Top 5
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.topBooks && stats.topBooks.length > 0" class="space-y-4">
                                <div v-for="(book, index) in stats.topBooks.slice(0, 5)" :key="book.BookID" 
                                         class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                            {{ index + 1 }}
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ book.Title }}</p>
                                            <p class="text-sm text-gray-600">{{ book.Author }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ book.TotalSold }} cuốn</p>
                                            <p class="text-sm text-green-600">{{ formatCurrency(book.TotalRevenue) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p>Chưa có dữ liệu bán hàng</p>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Books -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-red-50 to-pink-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">⚠️ Sách Tồn Kho Thấp</h3>
                                    <span class="px-3 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                        Cần nhập hàng
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.lowStockBooks && stats.lowStockBooks.length > 0" class="space-y-4">
                                <div v-for="book in stats.lowStockBooks.slice(0, 5)" :key="book.BookID" 
                                         class="flex items-center justify-between p-4 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ book.Title }}</p>
                                        <p class="text-sm text-gray-600">{{ book.Author }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-red-600">{{ book.Stock }} cuốn</p>
                                        <p class="text-sm text-gray-600">{{ book.SupplierName }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>Tất cả sách đều có đủ tồn kho</p>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Customer & Supplier Analytics -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Top Customers -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">👥 Top Khách Hàng</h3>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                        VIP
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.topCustomers && stats.topCustomers.length > 0" class="space-y-4">
                                <div v-for="(customer, index) in stats.topCustomers.slice(0, 5)" :key="customer.CustomerID" 
                                         class="flex items-center justify-between p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <span class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-semibold mr-3">
                                            {{ index + 1 }}
                                        </span>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ customer.Name }}</p>
                                            <p class="text-sm text-gray-600">{{ customer.Email }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ customer.OrderCount }} đơn</p>
                                        <p class="text-sm text-blue-600">{{ formatCurrency(customer.TotalSpent) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <p>Chưa có dữ liệu khách hàng</p>
                            </div>
                        </div>
                    </div>

                    <!-- Supplier Performance -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">🏢 Hiệu Suất Nhà Cung Cấp</h3>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                                        Đối tác
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.supplierStats && stats.supplierStats.length > 0" class="space-y-4">
                                <div v-for="supplier in stats.supplierStats.slice(0, 5)" :key="supplier.SupplierID" 
                                         class="flex items-center justify-between p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ supplier.SupplierName }}</p>
                                        <p class="text-sm text-gray-600">{{ supplier.BookCount }} sách</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ supplier.TotalSold }} cuốn</p>
                                        <p class="text-sm text-purple-600">{{ formatCurrency(supplier.TotalRevenue) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <p>Chưa có dữ liệu nhà cung cấp</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Panel -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">⚡ Hành Động Nhanh</h3>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full">
                                Quản lý nhanh
                            </span>
                        </div>
                        <p class="text-gray-600 mt-2">Truy cập nhanh các chức năng quản lý chính</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <button @click="activeTab = 'books'" class="flex items-center justify-center p-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 transform hover:scale-105">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span class="font-semibold">Quản lý Sách</span>
                                </div>
                            </button>
                            
                            <button @click="activeTab = 'customers'" class="flex items-center justify-center p-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-semibold">Quản lý KH</span>
                                </div>
                            </button>
                            
                            <button @click="activeTab = 'orders'" class="flex items-center justify-center p-4 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-lg hover:from-purple-600 hover:to-pink-700 transition-all duration-200 transform hover:scale-105">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-semibold">Quản lý ĐH</span>
                                </div>
                            </button>
                            
                            <button @click="activeTab = 'suppliers'" class="flex items-center justify-center p-4 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-lg hover:from-orange-600 hover:to-red-700 transition-all duration-200 transform hover:scale-105">
                                <div class="text-center">
                                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="font-semibold">Quản lý NCC</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Advanced Analytics & Insights -->
                <div class="space-y-8">
                    <!-- Section Header -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">🔍 Phân Tích Nâng Cao & Thông Tin Chi Tiết</h2>
                            <p class="text-gray-600">Phân tích sâu về hiệu suất và xu hướng kinh doanh</p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="showInsights" class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors duration-200 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                <span>Xem thông tin chi tiết</span>
                            </button>
                        </div>
                    </div>

                    <!-- Order & Inventory Statistics -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Order Status Statistics -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">📋 Thống Kê Đơn Hàng</h3>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">
                                        Tổng quan
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.orderStatusStats && stats.orderStatusStats.length > 0" class="space-y-4">
                                <div v-for="status in stats.orderStatusStats" :key="status.Status" 
                                         class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ status.Status }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ status.Count }}</p>
                                        <p class="text-sm text-gray-600">{{ formatCurrency(status.TotalValue) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <p>Chưa có dữ liệu đơn hàng</p>
                            </div>
                        </div>
                    </div>

                    <!-- Genre Statistics -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">📚 Thống Kê Thể Loại</h3>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                        Phân loại
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.genreStats && stats.genreStats.length > 0" class="space-y-4">
                                <div v-for="genre in stats.genreStats.slice(0, 5)" :key="genre.Genre" 
                                         class="flex items-center justify-between p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ genre.Genre }}</p>
                                        <p class="text-sm text-gray-600">{{ genre.BookCount }} sách</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900">{{ genre.TotalSold }} cuốn</p>
                                        <p class="text-sm text-green-600">{{ formatCurrency(genre.TotalRevenue) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <p>Chưa có dữ liệu thể loại</p>
                            </div>
                        </div>
                    </div>

                    <!-- Inventory Statistics -->
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-red-50">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">📦 Thống Kê Tồn Kho</h3>
                                    <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-full">
                                        Tồn kho
                                    </span>
                                </div>
                        </div>
                        <div class="p-6">
                            <div v-if="stats.inventoryStats" class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-orange-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Tổng giá trị</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-orange-600">{{ formatCurrency(stats.inventoryStats.TotalValue) }}</p>
                                    </div>
                                </div>
                                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Tồn kho thấp</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-red-600">{{ stats.inventoryStats.LowStockCount }} sách</p>
                                    </div>
                                </div>
                                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Tồn kho cao</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-green-600">{{ stats.inventoryStats.HighStockCount }} sách</p>
                                    </div>
                                </div>
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Hết hàng</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-600">{{ stats.inventoryStats.OutOfStockCount }} sách</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-8">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p>Chưa có dữ liệu tồn kho</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Statistics Section -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                            <div class="flex items-center justify-between">
                                <h3 class="text-2xl font-bold text-gray-900">💰 Thống Kê Doanh Thu</h3>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                    Phân tích tài chính
                                </span>
                            </div>
                            <p class="text-gray-600 mt-2">Phân tích doanh thu theo thời gian</p>
                    </div>

                    <!-- Revenue Summary Cards -->
                        <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm opacity-90">Tuần này</p>
                                    <p class="text-2xl font-bold">{{ formatCurrency(stats.revenueStats?.summary?.ThisWeekRevenue || 0) }}</p>
                                    <p class="text-xs opacity-75">{{ stats.revenueStats?.summary?.ThisWeekOrders || 0 }} đơn hàng</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm opacity-90">Tháng này</p>
                                    <p class="text-2xl font-bold">{{ formatCurrency(stats.revenueStats?.summary?.ThisMonthRevenue || 0) }}</p>
                                    <p class="text-xs opacity-75">{{ stats.revenueStats?.summary?.ThisMonthOrders || 0 }} đơn hàng</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm opacity-90">Năm này</p>
                                    <p class="text-2xl font-bold">{{ formatCurrency(stats.revenueStats?.summary?.ThisYearRevenue || 0) }}</p>
                                    <p class="text-xs opacity-75">{{ stats.revenueStats?.summary?.ThisYearOrders || 0 }} đơn hàng</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-xl p-6 text-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm opacity-90">Giá trị TB</p>
                                    <p class="text-2xl font-bold">{{ formatCurrency(stats.revenueStats?.summary?.AverageOrderValue || 0) }}</p>
                                    <p class="text-xs opacity-75">Đơn hàng trung bình</p>
                                </div>
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Revenue Tables -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Weekly Revenue -->
                        <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">📅 Doanh Thu Theo Tuần</h4>
                            <div v-if="stats.revenueStats?.weekly && stats.revenueStats.weekly.length > 0" class="space-y-3">
                                <div v-for="week in stats.revenueStats.weekly" :key="week.WeekNumber" 
                                             class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">Tuần {{ week.WeekNumber }}</p>
                                        <p class="text-xs text-gray-600">{{ week.WeekStart }} - {{ week.WeekEnd }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-green-600">{{ formatCurrency(week.Revenue) }}</p>
                                        <p class="text-xs text-gray-600">{{ week.OrderCount }} đơn</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-4">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p>Chưa có dữ liệu</p>
                            </div>
                        </div>

                        <!-- Monthly Revenue -->
                        <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">📊 Doanh Thu Theo Tháng</h4>
                            <div v-if="stats.revenueStats?.monthly && stats.revenueStats.monthly.length > 0" class="space-y-3">
                                <div v-for="month in stats.revenueStats.monthly.slice(0, 6)" :key="month.Month" 
                                             class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ month.Month }}</p>
                                        <p class="text-xs text-gray-600">{{ month.UniqueCustomers }} khách hàng</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-blue-600">{{ formatCurrency(month.Revenue) }}</p>
                                        <p class="text-xs text-gray-600">{{ month.OrderCount }} đơn</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-4">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <p>Chưa có dữ liệu</p>
                            </div>
                        </div>

                        <!-- Yearly Revenue -->
                        <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">📈 Doanh Thu Theo Năm</h4>
                            <div v-if="stats.revenueStats?.yearly && stats.revenueStats.yearly.length > 0" class="space-y-3">
                                <div v-for="year in stats.revenueStats.yearly" :key="year.Year" 
                                             class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div>
                                        <p class="font-medium text-gray-900">Năm {{ year.Year }}</p>
                                        <p class="text-xs text-gray-600">{{ year.UniqueCustomers }} khách hàng</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-purple-600">{{ formatCurrency(year.Revenue) }}</p>
                                        <p class="text-xs text-gray-600">{{ year.OrderCount }} đơn</p>
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-center text-gray-500 py-4">
                                        <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        <p>Chưa có dữ liệu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Books Tab -->
            <div v-if="activeTab === 'books'" class="space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Quản lý Sách</h2>
                        <p class="text-gray-600 mt-1">Quản lý thông tin sách, tác giả và tồn kho</p>
                    </div>
                                         <button @click="openBookModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Thêm sách mới
                    </button>
                </div>

                <!-- Search -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                v-model="bookSearch" 
                                @input="searchBooks" 
                                type="text" 
                                placeholder="Tìm kiếm sách theo tên, tác giả hoặc thể loại..." 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            >
                        </div>
                                                 <button @click="searchBooks" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Tìm kiếm
                        </button>
                    </div>
                </div>

                <!-- Books Table -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Danh sách sách</h3>
                        <p class="text-sm text-gray-600">Quản lý thông tin sách trong hệ thống</p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tên sách</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tác giả</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thể loại</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Giá</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nhập vào</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Xuất ra</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tồn kho</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nhà cung cấp</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="book in books" :key="book.BookID" class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ book.BookID }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ book.Title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ book.Author }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                                 <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ book.Genre }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">{{ formatCurrency(book.Price) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">{{ book.InputQuantity || 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-orange-600 font-medium">{{ book.OutputQuantity || 0 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="[
                                            'inline-flex px-2 py-1 text-xs font-semibold rounded-full',
                                            book.Stock > 10 ? 'bg-green-100 text-green-800' : 
                                            book.Stock > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'
                                        ]">
                                            {{ book.Stock }} cuốn
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ book.SupplierName }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                                                                         <button @click="editBook(book)" class="inline-flex items-center px-3 py-1 border border-green-300 rounded-md text-xs font-medium text-green-700 bg-green-50 hover:bg-green-100 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Sửa
                                            </button>
                                            <button @click="deleteBook(book.BookID)" class="inline-flex items-center px-3 py-1 border border-red-300 rounded-md text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Customers Tab -->
            <div v-if="activeTab === 'customers'" class="space-y-6">
                                 <div class="flex justify-between items-center">
                     <div>
                         <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Quản lý Khách hàng</h2>
                         <p class="text-gray-600 mt-1">Quản lý thông tin khách hàng và lịch sử mua hàng</p>
                     </div>
                     <button @click="openCustomerModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                         <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                         </svg>
                         Thêm khách hàng
                     </button>
                 </div>

                                 <!-- Search -->
                 <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                     <div class="flex items-center space-x-4">
                         <div class="flex-1 relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                 <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                 </svg>
                             </div>
                             <input 
                                 v-model="customerSearch" 
                                 @input="searchCustomers" 
                                 type="text" 
                                 placeholder="Tìm kiếm khách hàng theo tên, email hoặc số điện thoại..." 
                                 class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                             >
                         </div>
                         <button @click="searchCustomers" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                             </svg>
                             Tìm kiếm
                         </button>
                     </div>
                 </div>

                <!-- Customers Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số điện thoại</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số đơn hàng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng chi tiêu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="customer in customers" :key="customer.CustomerID">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ customer.CustomerID }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ customer.Name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ customer.Email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ customer.Phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ customer.TotalOrders || 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatCurrency(customer.TotalSpent || 0) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                         <button @click="editCustomer(customer)" class="text-green-600 hover:text-green-900 mr-3">Sửa</button>
                                    <button @click="deleteCustomer(customer.CustomerID)" class="text-red-600 hover:text-red-900">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Orders Tab -->
            <div v-if="activeTab === 'orders'" class="space-y-6">
                                 <div class="flex justify-between items-center">
                     <div>
                         <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Quản lý Đơn hàng</h2>
                         <p class="text-gray-600 mt-1">Quản lý đơn hàng và theo dõi trạng thái</p>
                     </div>
                     <button @click="openOrderModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                         <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                         </svg>
                         Tạo đơn hàng
                     </button>
                 </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Khách hàng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày đặt</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số sản phẩm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="order in orders" :key="order.OrderID">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ order.OrderID }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.CustomerName }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatDate(order.OrderDate) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatCurrency(order.TotalAmount) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ order.TotalItems || 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                         <button @click="viewOrderDetails(order.OrderID)" class="text-green-600 hover:text-green-900 mr-3">Chi tiết</button>
                                    <button @click="deleteOrder(order.OrderID)" class="text-red-600 hover:text-red-900">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Details Tab -->
            <div v-if="activeTab === 'orderDetails'" class="space-y-6">
                                 <div class="flex justify-between items-center">
                     <div>
                         <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Chi tiết Đơn hàng</h2>
                         <p class="text-gray-600 mt-1">Xem chi tiết sản phẩm trong đơn hàng</p>
                     </div>
                     <div class="flex space-x-2">
                         <select v-model="selectedOrderId" @change="loadOrderDetails" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                             <option value="">Chọn đơn hàng</option>
                             <option v-for="order in orders" :key="order.OrderID" :value="order.OrderID">
                                 Đơn hàng #{{ order.OrderID }} - {{ order.CustomerName }}
                             </option>
                         </select>
                     </div>
                 </div>

                                 <!-- Order Details Table -->
                 <div v-if="orderDetails.length > 0" class="bg-white rounded-lg shadow overflow-hidden">
                     <div class="p-4 bg-blue-50 border-b">
                         <h3 class="text-lg font-semibold text-blue-900">Chi tiết đơn hàng #{{ selectedOrderId }}</h3>
                         <p class="text-sm text-blue-700">Tổng cộng: {{ orderDetails.length }} sản phẩm</p>
                     </div>
                     <table class="min-w-full divide-y divide-gray-200">
                         <thead class="bg-gray-50">
                             <tr>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sách</th>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tác giả</th>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số lượng</th>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Giá</th>
                                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thành tiền</th>
                             </tr>
                         </thead>
                         <tbody class="bg-white divide-y divide-gray-200">
                             <tr v-for="detail in orderDetails" :key="`${detail.OrderID}-${detail.BookID}`">
                                 <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ detail.Title }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ detail.Author }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ detail.Quantity }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatCurrency(detail.Price) }}</td>
                                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ formatCurrency(detail.Quantity * detail.Price) }}</td>
                             </tr>
                         </tbody>
                     </table>
                     <div class="p-4 bg-gray-50 border-t">
                         <div class="flex justify-between items-center">
                             <span class="text-sm text-gray-600">Tổng tiền đơn hàng:</span>
                             <span class="text-lg font-semibold text-gray-900">
                                 {{ formatCurrency(orderDetails.reduce((sum, detail) => sum + (detail.Quantity * detail.Price), 0)) }}
                             </span>
                         </div>
                     </div>
                 </div>
                 <div v-else-if="selectedOrderId" class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                     <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-4"></div>
                     Đang tải chi tiết đơn hàng...
                 </div>
                 <div v-else class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                     Vui lòng chọn một đơn hàng để xem chi tiết
                 </div>
            </div>

            <!-- Suppliers Tab -->
            <div v-if="activeTab === 'suppliers'" class="space-y-6">
                                 <div class="flex justify-between items-center">
                     <div>
                         <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Quản lý Nhà cung cấp</h2>
                         <p class="text-gray-600 mt-1">Quản lý thông tin nhà cung cấp và sản phẩm</p>
                     </div>
                     <button @click="openSupplierModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                         <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                         </svg>
                         Thêm nhà cung cấp
                     </button>
                 </div>

                                 <!-- Search -->
                 <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                     <div class="flex items-center space-x-4">
                         <div class="flex-1 relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                 <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                 </svg>
                             </div>
                             <input 
                                 v-model="supplierSearch" 
                                 @input="searchSuppliers" 
                                 type="text" 
                                 placeholder="Tìm kiếm nhà cung cấp theo tên, địa chỉ hoặc số điện thoại..." 
                                 class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                             >
                         </div>
                         <button @click="searchSuppliers" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
                             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                             </svg>
                             Tìm kiếm
                         </button>
                     </div>
                 </div>

                <!-- Suppliers Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tên</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Địa chỉ</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số điện thoại</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Số sách</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng tồn kho</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="supplier in suppliers" :key="supplier.SupplierID">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ supplier.SupplierID }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ supplier.Name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ supplier.Address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ supplier.Phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ supplier.TotalBooks || 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ supplier.TotalStock || 0 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                                         <button @click="editSupplier(supplier)" class="text-green-600 hover:text-green-900 mr-3">Sửa</button>
                                    <button @click="deleteSupplier(supplier.SupplierID)" class="text-red-600 hover:text-red-900">Xóa</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Promotions Tab -->
            <div v-if="activeTab === 'promotions'" class="space-y-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Quản lý Khuyến mãi</h2>
                        <p class="text-gray-600 mt-1">Quản lý chương trình khuyến mãi và mã giảm giá</p>
                    </div>
                    <button @click="openPromotionModal()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Thêm khuyến mãi
                    </button>
                </div>

                <!-- Search -->
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                v-model="promotionSearch" 
                                @input="searchPromotions" 
                                type="text" 
                                placeholder="Tìm kiếm khuyến mãi theo mã, tên hoặc mô tả..." 
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                            >
                        </div>
                        <button @click="searchPromotions" class="inline-flex items-center px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Tìm kiếm
                        </button>
                    </div>
                </div>

                <!-- Promotions Table with Horizontal Scroll -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Mã</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Tên khuyến mãi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Loại giảm giá</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Giá trị</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Điều kiện</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Thời gian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Trạng thái</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Sử dụng</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="promotion in promotions" :key="promotion.PromotionID">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ promotion.PromotionCode }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ promotion.PromotionName }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            promotion.DiscountType === 'percentage' 
                                                ? 'bg-blue-100 text-blue-800' 
                                                : 'bg-purple-100 text-purple-800'
                                        ]">
                                            {{ promotion.DiscountType === 'percentage' ? 'Phần trăm' : 'Số tiền' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ promotion.DiscountType === 'percentage' ? promotion.DiscountValue + '%' : formatCurrency(promotion.DiscountValue) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Từ {{ formatCurrency(promotion.MinimumOrderAmount) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="text-xs">
                                            <div>Từ: {{ formatDate(promotion.StartDate) }}</div>
                                            <div>Đến: {{ formatDate(promotion.EndDate) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span :class="[
                                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                            promotion.IsActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                        ]">
                                            {{ promotion.IsActive ? 'Hoạt động' : 'Tạm dừng' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ promotion.UsedCount || 0 }}/{{ promotion.UsageLimit || '∞' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="editPromotion(promotion)" class="text-green-600 hover:text-green-900 mr-3">Sửa</button>
                                        <button @click="deletePromotion(promotion.PromotionID)" class="text-red-600 hover:text-red-900">Xóa</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Scroll hint -->
                    <div class="px-6 py-2 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex items-center justify-center">
                        <i class="fas fa-arrows-alt-h mr-2"></i>
                        Cuộn ngang để xem thêm thông tin
                    </div>
                </div>

                <!-- Empty State -->
                <div v-if="promotions.length === 0" class="bg-white rounded-lg shadow p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Chưa có khuyến mãi</h3>
                    <p class="mt-1 text-sm text-gray-500">Bắt đầu tạo khuyến mãi đầu tiên để thu hút khách hàng.</p>
                    <div class="mt-6">
                        <button @click="openPromotionModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Thêm khuyến mãi
                        </button>
                    </div>
                </div>
            </div>
        </main>

                 <!-- Loading Overlay -->
         <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
             <div class="bg-white p-8 rounded-2xl shadow-2xl border border-gray-200 max-w-sm w-full mx-4">
                 <div class="flex flex-col items-center">
                     <div class="relative">
                         <div class="w-16 h-16 border-4 border-green-200 rounded-full"></div>
                         <div class="absolute top-0 left-0 w-16 h-16 border-4 border-green-600 rounded-full border-t-transparent animate-spin"></div>
                     </div>
                     <h3 class="mt-4 text-lg font-semibold text-gray-900">Đang tải dữ liệu</h3>
                     <p class="mt-2 text-sm text-gray-600 text-center">Vui lòng chờ trong giây lát...</p>
                 </div>
             </div>
         </div>

         <!-- Book Modal -->
         <div v-if="showBookModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
             <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                 <div class="p-6 border-b border-gray-200">
                     <div class="flex items-center justify-between">
                         <h3 class="text-xl font-semibold text-gray-900">
                             {{ isEditingBook ? 'Sửa sách' : 'Thêm sách mới' }}
                         </h3>
                         <button @click="closeBookModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                             </svg>
                         </button>
                     </div>
                 </div>
                 
                 <form @submit.prevent="saveBook" class="p-6 space-y-6">
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Tên sách *</label>
                             <input 
                                 v-model="bookForm.Title" 
                                 type="text" 
                                 required
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                 placeholder="Nhập tên sách"
                             >
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Tác giả *</label>
                             <input 
                                 v-model="bookForm.Author" 
                                 type="text" 
                                 required
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                 placeholder="Nhập tên tác giả"
                             >
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Thể loại *</label>
                             <select 
                                 v-model="bookForm.Genre" 
                                 required
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                             >
                                 <option value="">Chọn thể loại</option>
                                 <option value="Văn học">Văn học</option>
                                 <option value="Kỹ năng sống">Kỹ năng sống</option>
                                 <option value="Khoa học">Khoa học</option>
                                 <option value="Giáo dục">Giáo dục</option>
                                 <option value="Kinh tế">Kinh tế</option>
                                 <option value="Lịch sử">Lịch sử</option>
                                 <option value="Văn hóa">Văn hóa</option>
                                 <option value="Khác">Khác</option>
                             </select>
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Giá (VND) *</label>
                             <input 
                                 v-model="bookForm.Price" 
                                 type="number" 
                                 required
                                 min="0"
                                 step="1000"
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                 placeholder="Nhập giá sách"
                             >
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng nhập vào *</label>
                             <input 
                                 v-model="bookForm.InputQuantity" 
                                 type="number" 
                                 required
                                 min="0"
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                 placeholder="Nhập số lượng nhập vào"
                             >
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng xuất ra</label>
                             <input 
                                 v-model="bookForm.OutputQuantity" 
                                 type="number" 
                                 min="0"
                                 readonly
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                                 placeholder="Tự động tính từ đơn hàng"
                             >
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Tồn kho hiện tại</label>
                             <input 
                                 :value="calculateCurrentStock()" 
                                 type="number" 
                                 readonly
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                                 placeholder="Tự động tính toán"
                             >
                         </div>
                         
                         <div>
                             <label class="block text-sm font-medium text-gray-700 mb-2">Nhà cung cấp *</label>
                             <select 
                                 v-model="bookForm.SupplierID" 
                                 required
                                 class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                             >
                                 <option value="">Chọn nhà cung cấp</option>
                                 <option v-for="supplier in suppliers" :key="supplier.SupplierID" :value="supplier.SupplierID">
                                     {{ supplier.Name }}
                                 </option>
                             </select>
                         </div>
                     </div>
                     
                     <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                         <button 
                             type="button" 
                             @click="closeBookModal"
                             class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                         >
                             Hủy
                         </button>
                         <button 
                             type="submit" 
                             :disabled="savingBook"
                             class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                         >
                             <span v-if="savingBook" class="flex items-center">
                                 <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                     <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                     <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                 </svg>
                                 Đang lưu...
                             </span>
                             <span v-else>{{ isEditingBook ? 'Cập nhật' : 'Thêm sách' }}</span>
                         </button>
                     </div>
                 </form>
             </div>
         </div>

                   <!-- Customer Modal -->
          <div v-if="showCustomerModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
              <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                  <div class="p-6 border-b border-gray-200">
                      <div class="flex items-center justify-between">
                          <h3 class="text-xl font-semibold text-gray-900">
                              {{ isEditingCustomer ? 'Sửa khách hàng' : 'Thêm khách hàng mới' }}
                          </h3>
                          <button @click="closeCustomerModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                              </svg>
                          </button>
                      </div>
                  </div>
                  
                  <form @submit.prevent="saveCustomer" class="p-6 space-y-6">
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Tên khách hàng *</label>
                              <input 
                                  v-model="customerForm.Name" 
                                  type="text" 
                                  required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                  placeholder="Nhập tên khách hàng"
                              >
                          </div>
                          
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                              <input 
                                  v-model="customerForm.Email" 
                                  type="email" 
                                  required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                  placeholder="Nhập email"
                              >
                          </div>
                          
                          <div>
                              <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                              <input 
                                  v-model="customerForm.Phone" 
                                  type="tel" 
                                  required
                                  pattern="[0-9]{10}"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                  placeholder="Nhập số điện thoại (10 số)"
                              >
                          </div>
                      </div>
                      
                      <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                          <button 
                              type="button" 
                              @click="closeCustomerModal"
                              class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                          >
                              Hủy
                          </button>
                          <button 
                              type="submit" 
                              :disabled="savingCustomer"
                              class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                          >
                              <span v-if="savingCustomer" class="flex items-center">
                                  <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                  </svg>
                                  Đang lưu...
                              </span>
                              <span v-else>{{ isEditingCustomer ? 'Cập nhật' : 'Thêm khách hàng' }}</span>
                          </button>
                      </div>
                  </form>
              </div>
          </div>

                     <!-- Order Modal -->
           <div v-if="showOrderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
               <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                   <div class="p-6 border-b border-gray-200">
                       <div class="flex items-center justify-between">
                           <h3 class="text-xl font-semibold text-gray-900">Tạo đơn hàng mới</h3>
                           <button @click="closeOrderModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                               </svg>
                           </button>
                       </div>
                   </div>
                   
                   <form @submit.prevent="saveOrder" class="p-6 space-y-6">
                       <!-- Customer Information Section -->
                       <div class="bg-gray-50 p-4 rounded-lg">
                           <h4 class="text-lg font-semibold text-gray-900 mb-4">Thông tin khách hàng</h4>
                           <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                               <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Chọn khách hàng</label>
                                   <select 
                                       v-model="orderForm.customerType" 
                                       @change="handleCustomerTypeChange"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   >
                                       <option value="existing">Khách hàng hiện có</option>
                                       <option value="new">Khách hàng mới</option>
                                   </select>
                               </div>
                               
                               <div v-if="orderForm.customerType === 'existing'">
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Khách hàng *</label>
                                   <select 
                                       v-model="orderForm.CustomerID" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   >
                                       <option value="">Chọn khách hàng</option>
                                       <option v-for="customer in customers" :key="customer.CustomerID" :value="customer.CustomerID">
                                           {{ customer.Name }} - {{ customer.Phone }}
                                       </option>
                                   </select>
                               </div>
                           </div>
                           
                           <!-- New Customer Form -->
                           <div v-if="orderForm.customerType === 'new'" class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                               <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Tên khách hàng *</label>
                                   <input 
                                       v-model="orderForm.newCustomer.Name" 
                                       type="text" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                       placeholder="Nhập tên khách hàng"
                                   >
                               </div>
                               
                               <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                   <input 
                                       v-model="orderForm.newCustomer.Email" 
                                       type="email" 
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                       placeholder="Nhập email"
                                   >
                               </div>
                               
                               <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                                   <input 
                                       v-model="orderForm.newCustomer.Phone" 
                                       type="tel" 
                                       required
                                       pattern="[0-9]{10}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                       placeholder="Nhập số điện thoại (10 số)"
                                   >
                               </div>
                           </div>
                       </div>

                       <!-- Order Items Section -->
                       <div class="bg-gray-50 p-4 rounded-lg">
                           <div class="flex items-center justify-between mb-4">
                               <h4 class="text-lg font-semibold text-gray-900">Chi tiết đơn hàng</h4>
                               <button 
                                   type="button"
                                   @click="addOrderItem"
                                   class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200"
                               >
                                   <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                   </svg>
                                   Thêm sản phẩm
                               </button>
                           </div>
                           
                           <div v-for="(item, index) in orderForm.items" :key="index" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 p-4 bg-white rounded-lg border">
                                                              <div class="relative">
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Sách *</label>
                                   <div class="relative">
                                       <input 
                                           v-model="item.bookSearch" 
                                           @input="searchBooksInOrder(index, $event.target.value)"
                                           @focus="showBookDropdown(index)"
                                           @blur="hideBookDropdown(index)"
                                           @keydown="handleBookInputKeydown(index, $event)"
                                           type="text" 
                                       required
                                           class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                           :placeholder="item.BookID ? getSelectedBookTitle(index) : 'Chọn sách hoặc tìm kiếm...'"
                                       >
                                       <div class="absolute inset-y-0 right-0 flex items-center pr-3 space-x-1">
                                           <button 
                                               v-if="item.BookID" 
                                               type="button"
                                               @click="clearBookSelection(index)"
                                               class="text-red-500 hover:text-red-700 transition-colors"
                                               title="Xóa lựa chọn"
                                           >
                                               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                               </svg>
                                           </button>
                                           <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                           </svg>
                                       </div>
                                   </div>
                                   
                                   <!-- Book Search Dropdown -->
                                   <div v-if="item.showBookDropdown" 
                                        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                       <!-- Search Results -->
                                       <div v-if="item.bookSearch && item.filteredBooks.length > 0" class="border-b border-gray-200">
                                           <div class="px-3 py-2 bg-gray-50 text-xs font-medium text-gray-600">
                                               Kết quả tìm kiếm ({{ item.filteredBooks.length }})
                                           </div>
                                           <div v-for="book in item.filteredBooks" 
                                                :key="book.BookID"
                                                @click="selectBook(index, book)"
                                                :class="[
                                                    'px-4 py-3 cursor-pointer border-b border-gray-100 last:border-b-0',
                                                    book.Stock > 0 ? 'hover:bg-gray-100' : 'bg-red-50 hover:bg-red-100 opacity-60'
                                                ]">
                                               <div class="font-medium text-gray-900">{{ book.Title }}</div>
                                               <div class="text-sm text-gray-600">
                                                   <span class="font-medium">Giá:</span> {{ formatCurrency(book.Price) }} | 
                                                   <span class="font-medium" :class="getStockStatusClass(book.Stock)">
                                                       Tồn kho: {{ book.Stock || 0 }}
                                                       <span v-if="book.Stock === 0" class="text-red-600 font-semibold">(Hết hàng)</span>
                                                       <span v-else-if="book.Stock <= 5" class="text-orange-600 font-semibold">(Tồn kho thấp)</span>
                                                   </span>
                                               </div>
                                           </div>
                                       </div>
                                       
                                       <!-- All Books List -->
                                       <div v-if="!item.bookSearch || item.filteredBooks.length === 0">
                                           <div class="px-3 py-2 bg-gray-50 text-xs font-medium text-gray-600">
                                               Tất cả sách ({{ books.length }})
                                           </div>
                                           <div v-for="book in books.slice(0, 10)" 
                                                :key="book.BookID"
                                                @click="selectBook(index, book)"
                                                :class="[
                                                    'px-4 py-3 cursor-pointer border-b border-gray-100 last:border-b-0',
                                                    book.Stock > 0 ? 'hover:bg-gray-100' : 'bg-red-50 hover:bg-red-100 opacity-60'
                                                ]">
                                               <div class="font-medium text-gray-900">{{ book.Title }}</div>
                                               <div class="text-sm text-gray-600">
                                                   <span class="font-medium">Giá:</span> {{ formatCurrency(book.Price) }} | 
                                                   <span class="font-medium" :class="getStockStatusClass(book.Stock)">
                                                       Tồn kho: {{ book.Stock || 0 }}
                                                       <span v-if="book.Stock === 0" class="text-red-600 font-semibold">(Hết hàng)</span>
                                                       <span v-else-if="book.Stock <= 5" class="text-orange-600 font-semibold">(Tồn kho thấp)</span>
                                                   </span>
                                               </div>
                                           </div>
                                           <div v-if="books.length > 10" class="px-4 py-2 text-xs text-gray-500 text-center border-t border-gray-100">
                                               Hiển thị 10 sách đầu tiên. Gõ để tìm kiếm cụ thể hơn.
                                           </div>
                                       </div>
                                   </div>
                                   
                                   <!-- No Results Message -->
                                   <div v-if="item.showBookDropdown && item.bookSearch && item.filteredBooks.length === 0" 
                                        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg">
                                       <div class="px-4 py-3 text-gray-500 text-center">
                                           <div class="text-sm">Không tìm thấy sách phù hợp</div>
                                           <div class="text-xs mt-1">Thử tìm kiếm với từ khóa khác</div>
                                       </div>
                                   </div>
                                   
                                   <!-- Selected Book Info -->
                                   <div v-if="item.BookID" class="mt-2 p-2 rounded-lg border" :class="getSelectedBookInfoClass(index)">
                                       <div class="flex items-center justify-between text-sm mb-1">
                                           <span class="font-medium" :class="getSelectedBookTitleClass(index)">
                                               {{ getSelectedBookTitle(index) }}
                                           </span>
                                           <span :class="getSelectedBookPriceClass(index)">
                                               {{ formatCurrency(getSelectedBookPrice(index)) }}
                                           </span>
                                       </div>
                                       <div class="text-xs" :class="getSelectedBookStockClass(index)">
                                           <span class="font-medium">Tồn kho:</span> {{ getSelectedBookStock(index) }}
                                           <span v-if="getSelectedBookStock(index) === 0" class="text-red-600 font-semibold ml-1">(Hết hàng)</span>
                                           <span v-else-if="getSelectedBookStock(index) <= 5" class="text-orange-600 font-semibold ml-1">(Tồn kho thấp)</span>
                                       </div>
                                   </div>
                               </div>
                               
                               <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Số lượng *</label>
                                   <input 
                                       v-model="item.Quantity" 
                                       type="number" 
                                       :min="0"
                                       :max="getSelectedBookStock(index)"
                                       @input="handleQuantityChange(index)"
                                       required
                                       :class="[
                                           'w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200',
                                           isQuantityValid(index) ? 'border-gray-300' : 'border-red-500 bg-red-50'
                                       ]"
                                       placeholder="Số lượng"
                                   >
                                   <div v-if="!isQuantityValid(index)" class="mt-1 text-xs text-red-600">
                                       Số lượng không được vượt quá tồn kho ({{ getSelectedBookStock(index) }})
                                   </div>
                                   <div v-if="getSelectedBookStock(index) <= 5 && getSelectedBookStock(index) > 0" class="mt-1 text-xs text-orange-600">
                                       ⚠️ Tồn kho thấp, chỉ còn {{ getSelectedBookStock(index) }} cuốn
                                   </div>
                               </div>
                               
                               <div>
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Đơn giá</label>
                                   <input 
                                       v-model="item.Price" 
                                       type="number" 
                                       readonly
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700"
                                       placeholder="Đơn giá"
                                   >
                               </div>
                               
                               <div class="flex items-end space-x-2">
                                   <div class="flex-1">
                                       <label class="block text-sm font-medium text-gray-700 mb-2">Thành tiền</label>
                                       <input 
                                           v-model="item.Total" 
                                           type="number" 
                                           readonly
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-700 font-semibold"
                                           placeholder="Thành tiền"
                                       >
                                   </div>
                                   <button 
                                       type="button"
                                       @click="removeOrderItem(index)"
                                       class="px-3 py-2 text-red-600 hover:text-red-800 transition-colors duration-200"
                                   >
                                       <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                       </svg>
                                   </button>
                               </div>
                           </div>
                           
                           <!-- Promotion and Payment Section -->
                           <div class="mt-6 p-4 bg-white rounded-lg border">
                               <h4 class="text-lg font-semibold text-gray-900 mb-4">Khuyến mãi & Thanh toán</h4>
                               
                               <!-- Promotion Code -->
                               <div class="mb-4">
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Mã khuyến mãi</label>
                                   <div class="flex space-x-2">
                                       <input 
                                           v-model="orderForm.PromotionCode"
                                           @input="validatePromotion"
                                           type="text" 
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                           placeholder="Nhập mã khuyến mãi (nếu có)"
                                       >
                                       <button 
                                           v-if="validatingPromotion"
                                           type="button"
                                           class="px-4 py-2 bg-gray-100 text-gray-500 rounded-lg cursor-not-allowed"
                                           disabled
                                       >
                                           <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                                               <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                               <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                           </svg>
                                       </button>
                                   </div>
                                   
                                   <!-- Promotion validation message -->
                                   <div v-if="promotionValidation" class="mt-2">
                                       <div v-if="promotionValidation.valid" class="text-sm text-green-600 bg-green-50 p-2 rounded">
                                           ✅ {{ promotionValidation.message || 'Mã khuyến mãi hợp lệ!' }}
                                       </div>
                                       <div v-else class="text-sm text-red-600 bg-red-50 p-2 rounded">
                                           ❌ {{ promotionValidation.message }}
                                       </div>
                                   </div>
                                   
                                   <!-- Available promotions -->
                                   <div v-if="promotions.length > 0" class="mt-2">
                                       <p class="text-xs text-gray-500 mb-1">Mã khuyến mãi có sẵn:</p>
                                       <div class="flex flex-wrap gap-1">
                                           <span 
                                               v-for="promotion in promotions.slice(0, 3)" 
                                               :key="promotion.PromotionID"
                                               class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded"
                                           >
                                               {{ promotion.PromotionCode }}
                                           </span>
                                       </div>
                                   </div>
                               </div>
                               
                               <!-- Payment Method -->
                               <div class="mb-4">
                                   <label class="block text-sm font-medium text-gray-700 mb-2">Phương thức thanh toán</label>
                                   <select 
                                       v-model="orderForm.PaymentMethodID"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   >
                                       <option value="">Chọn phương thức thanh toán</option>
                                       <option 
                                           v-for="method in paymentMethods" 
                                           :key="method.PaymentMethodID" 
                                           :value="method.PaymentMethodID"
                                       >
                                           {{ method.MethodName }}
                                       </option>
                                   </select>
                               </div>
                           </div>
                           
                           <!-- Order Summary -->
                           <div class="mt-6 p-4 bg-white rounded-lg border">
                               <h4 class="text-lg font-semibold text-gray-900 mb-4">Tổng kết đơn hàng</h4>
                               
                               <div class="space-y-2">
                                   <div class="flex justify-between items-center text-gray-700">
                                       <span>Tạm tính:</span>
                                       <span>{{ formatCurrency(orderSubTotal) }}</span>
                                   </div>
                                   
                                   <div v-if="orderDiscount > 0" class="flex justify-between items-center text-green-600">
                                       <span>Giảm giá:</span>
                                       <span>-{{ formatCurrency(orderDiscount) }}</span>
                                   </div>
                                   
                                   <div class="flex justify-between items-center text-lg font-semibold text-gray-900 border-t pt-2">
                                       <span>Tổng tiền:</span>
                                       <span class="text-green-600">{{ formatCurrency(orderTotal) }}</span>
                                   </div>
                               </div>
                           </div>
                       </div>
                       
                       <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                           <button 
                               type="button" 
                               @click="closeOrderModal"
                               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                           >
                               Hủy
                           </button>
                           <button 
                               type="submit" 
                               :disabled="savingOrder || orderForm.items.length === 0"
                               class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                           >
                               <span v-if="savingOrder" class="flex items-center">
                                   <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                       <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                       <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                   </svg>
                                   Đang tạo đơn hàng...
                               </span>
                               <span v-else>Tạo đơn hàng</span>
                           </button>
                       </div>
                   </form>
               </div>
           </div>

           <!-- Supplier Modal -->
           <div v-if="showSupplierModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
               <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                   <div class="p-6 border-b border-gray-200">
                       <div class="flex items-center justify-between">
                           <h3 class="text-xl font-semibold text-gray-900">
                               {{ isEditingSupplier ? 'Sửa nhà cung cấp' : 'Thêm nhà cung cấp mới' }}
                           </h3>
                           <button @click="closeSupplierModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                               </svg>
                           </button>
                       </div>
                   </div>
                   
                   <form @submit.prevent="saveSupplier" class="p-6 space-y-6">
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Tên nhà cung cấp *</label>
                               <input 
                                   v-model="supplierForm.Name" 
                                   type="text" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Nhập tên nhà cung cấp"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                               <input 
                                   v-model="supplierForm.Phone" 
                                   type="tel" 
                                   required
                                   pattern="[0-9]{10}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Nhập số điện thoại (10 số)"
                               >
                           </div>
                           
                           <div class="md:col-span-2">
                               <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ *</label>
                               <textarea 
                                   v-model="supplierForm.Address" 
                                   required
                                   rows="3"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Nhập địa chỉ nhà cung cấp"
                               ></textarea>
                           </div>
                       </div>
                       
                       <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                           <button 
                               type="button" 
                               @click="closeSupplierModal"
                               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                           >
                               Hủy
                           </button>
                           <button 
                               type="submit" 
                               :disabled="savingSupplier"
                               class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                           >
                               <span v-if="savingSupplier" class="flex items-center">
                                   <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                       <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                       <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                   </svg>
                                   Đang lưu...
                               </span>
                               <span v-else>{{ isEditingSupplier ? 'Cập nhật' : 'Thêm nhà cung cấp' }}</span>
                           </button>
                       </div>
                   </form>
               </div>
           </div>

           <!-- Promotion Modal -->
           <div v-if="showPromotionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm">
               <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                   <div class="p-6 border-b border-gray-200">
                       <div class="flex items-center justify-between">
                           <h3 class="text-xl font-semibold text-gray-900">
                               {{ isEditingPromotion ? 'Sửa khuyến mãi' : 'Thêm khuyến mãi mới' }}
                           </h3>
                           <button @click="closePromotionModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                               </svg>
                           </button>
                       </div>
                   </div>
                   
                   <form @submit.prevent="savePromotion" class="p-6 space-y-6">
                       <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Mã khuyến mãi *</label>
                               <input 
                                   v-model="promotionForm.PromotionCode" 
                                   type="text" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Ví dụ: WELCOME10"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Tên khuyến mãi *</label>
                               <input 
                                   v-model="promotionForm.PromotionName" 
                                   type="text" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Nhập tên khuyến mãi"
                               >
                           </div>
                           
                           <div class="md:col-span-2">
                               <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                               <textarea 
                                   v-model="promotionForm.Description" 
                                   rows="3"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Mô tả chi tiết về khuyến mãi"
                               ></textarea>
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Loại giảm giá *</label>
                               <select 
                                   v-model="promotionForm.DiscountType" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                               >
                                   <option value="">Chọn loại giảm giá</option>
                                   <option value="percentage">Phần trăm (%)</option>
                                   <option value="fixed_amount">Số tiền cố định</option>
                               </select>
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Giá trị giảm giá *</label>
                               <input 
                                   v-model="promotionForm.DiscountValue" 
                                   type="number" 
                                   required
                                   min="0"
                                   step="0.01"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   :placeholder="promotionForm.DiscountType === 'percentage' ? 'Ví dụ: 10' : 'Ví dụ: 20000'"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Đơn hàng tối thiểu</label>
                               <input 
                                   v-model="promotionForm.MinimumOrderAmount" 
                                   type="number" 
                                   min="0"
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Số tiền tối thiểu để áp dụng"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Giảm giá tối đa</label>
                               <input 
                                   v-model="promotionForm.MaximumDiscount" 
                                   type="number" 
                                   min="0"
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Giới hạn giảm giá tối đa"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Ngày bắt đầu *</label>
                               <input 
                                   v-model="promotionForm.StartDate" 
                                   type="date" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Ngày kết thúc *</label>
                               <input 
                                   v-model="promotionForm.EndDate" 
                                   type="date" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Giới hạn sử dụng</label>
                               <input 
                                   v-model="promotionForm.UsageLimit" 
                                   type="number" 
                                   min="1"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Số lần sử dụng tối đa"
                               >
                           </div>
                           
                           <div>
                               <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                               <select 
                                   v-model="promotionForm.IsActive" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                               >
                                   <option :value="true">Hoạt động</option>
                                   <option :value="false">Tạm dừng</option>
                               </select>
                           </div>
                           
                           <div class="md:col-span-2">
                               <label class="block text-sm font-medium text-gray-700 mb-2">Đối tượng áp dụng</label>
                               <select 
                                   v-model="promotionForm.TargetType" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                               >
                                   <option value="all">Tất cả</option>
                                   <option value="product">Sản phẩm cụ thể</option>
                                   <option value="customer">Khách hàng cụ thể</option>
                                   <option value="category">Danh mục sản phẩm</option>
                               </select>
                           </div>
                       </div>
                       
                       <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                           <button 
                               type="button" 
                               @click="closePromotionModal"
                               class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200"
                           >
                               Hủy
                           </button>
                           <button 
                               type="submit" 
                               :disabled="savingPromotion"
                               class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                           >
                               <span v-if="savingPromotion" class="flex items-center">
                                   <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                       <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                       <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                   </svg>
                                   Đang lưu...
                               </span>
                               <span v-else>{{ isEditingPromotion ? 'Cập nhật' : 'Thêm khuyến mãi' }}</span>
                           </button>
                       </div>
                   </form>
               </div>
           </div>
     </div>
 </template>

<script setup>
import { ref, onMounted, computed, watch } from 'vue';

// Reactive data
const activeTab = ref('dashboard');
const loading = ref(false);
const currentDate = ref('');
const currentTime = ref('');

// Dashboard data
const stats = ref({});
const recentOrders = ref([]);

// Books data
const books = ref([]);
const bookSearch = ref('');

// Book modal data
const showBookModal = ref(false);
const isEditingBook = ref(false);
const savingBook = ref(false);
const bookForm = ref({
    BookID: null,
    Title: '',
    Author: '',
    Genre: '',
    Price: '',
    InputQuantity: '',
    OutputQuantity: '',
    SupplierID: ''
});

// Customers data
const customers = ref([]);
const customerSearch = ref('');

// Customer modal data
const showCustomerModal = ref(false);
const isEditingCustomer = ref(false);
const savingCustomer = ref(false);
const customerForm = ref({
    CustomerID: null,
    Name: '',
    Email: '',
    Phone: ''
});

// Orders data
const orders = ref([]);

// Order modal data
const showOrderModal = ref(false);
const savingOrder = ref(false);
const orderForm = ref({
    customerType: 'existing',
    CustomerID: '',
    newCustomer: {
        Name: '',
        Email: '',
        Phone: ''
    },
    items: [],
    PromotionCode: '',
    PaymentMethodID: '',
    SubTotal: 0,
    DiscountAmount: 0,
    TotalAmount: 0
});

// Order details data
const orderDetails = ref([]);
const selectedOrderId = ref('');

// Suppliers data
const suppliers = ref([]);
const supplierSearch = ref('');

// Promotions and Payments data
const promotions = ref([]);
const paymentMethods = ref([]);
const promotionValidation = ref(null);
const validatingPromotion = ref(false);

// Promotion management data
const promotionSearch = ref('');
const showPromotionModal = ref(false);
const isEditingPromotion = ref(false);
const savingPromotion = ref(false);
const promotionForm = ref({
    PromotionID: null,
    PromotionCode: '',
    PromotionName: '',
    Description: '',
    DiscountType: '',
    DiscountValue: '',
    MinimumOrderAmount: '',
    MaximumDiscount: '',
    StartDate: '',
    EndDate: '',
    IsActive: true,
    UsageLimit: '',
    TargetType: 'all'
});

// Supplier modal data
const showSupplierModal = ref(false);
const isEditingSupplier = ref(false);
const savingSupplier = ref(false);
const supplierForm = ref({
    SupplierID: null,
    Name: '',
    Address: '',
    Phone: ''
});

// Utility functions
const formatCurrency = (value) => {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(value);
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('vi-VN');
};

// Calculate current stock from input and output quantities
const calculateCurrentStock = () => {
    const inputQty = parseInt(bookForm.value.InputQuantity) || 0;
    const outputQty = parseInt(bookForm.value.OutputQuantity) || 0;
    return Math.max(0, inputQty - outputQty);
};

// Helper functions for selected book info
const getSelectedBookTitle = (index) => {
    const item = orderForm.value.items[index];
    if (!item.BookID) return '';
    const selectedBook = books.value.find(book => book.BookID == item.BookID);
    return selectedBook ? selectedBook.Title : '';
};

const getSelectedBookPrice = (index) => {
    const item = orderForm.value.items[index];
    if (!item.BookID) return 0;
    const selectedBook = books.value.find(book => book.BookID == item.BookID);
    return selectedBook ? selectedBook.Price : 0;
};

// Stock-related helper functions
const getSelectedBookStock = (index) => {
    const item = orderForm.value.items[index];
    if (!item.BookID) return 0;
    const selectedBook = books.value.find(book => book.BookID == item.BookID);
    return selectedBook ? (selectedBook.Stock || 0) : 0;
};

const isQuantityValid = (index) => {
    const item = orderForm.value.items[index];
    const quantity = parseInt(item.Quantity) || 0;
    const stock = getSelectedBookStock(index);
    return quantity >= 0 && quantity <= stock;
};

const getStockStatusClass = (stockQuantity) => {
    if (stockQuantity === 0) return 'text-red-600';
    if (stockQuantity <= 5) return 'text-orange-600';
    return 'text-green-600';
};

const getSelectedBookInfoClass = (index) => {
    const stock = getSelectedBookStock(index);
    if (stock === 0) return 'bg-red-50 border-red-200';
    if (stock <= 5) return 'bg-orange-50 border-orange-200';
    return 'bg-green-50 border-green-200';
};

const getSelectedBookTitleClass = (index) => {
    const stock = getSelectedBookStock(index);
    if (stock === 0) return 'text-red-800';
    if (stock <= 5) return 'text-orange-800';
    return 'text-green-800';
};

const getSelectedBookPriceClass = (index) => {
    const stock = getSelectedBookStock(index);
    if (stock === 0) return 'text-red-600';
    if (stock <= 5) return 'text-orange-600';
    return 'text-green-600';
};

const getSelectedBookStockClass = (index) => {
    const stock = getSelectedBookStock(index);
    if (stock === 0) return 'text-red-700';
    if (stock <= 5) return 'text-orange-700';
    return 'text-green-700';
};

// Computed properties
const orderSubTotal = computed(() => {
    return orderForm.value.items
        .filter(item => item.BookID && parseInt(item.Quantity) > 0)
        .reduce((total, item) => total + (parseInt(item.Quantity) * parseFloat(item.Price)), 0);
});

const orderDiscount = computed(() => {
    if (promotionValidation.value && promotionValidation.value.valid && promotionValidation.value.promotion) {
        const promotion = promotionValidation.value.promotion;
        if (promotion.DiscountType === 'percentage') {
            return orderSubTotal.value * (promotion.DiscountValue / 100);
        } else {
            return promotion.DiscountValue;
        }
    }
    return 0;
});

const orderTotal = computed(() => {
    return orderSubTotal.value - orderDiscount.value;
});

// Watcher để tự động cập nhật tổng tiền khi có thay đổi
watch(() => orderForm.value.items, (newItems) => {
    newItems.forEach((item, index) => {
        if (item.BookID && (item.Price || item.Quantity)) {
            updateItemTotal(index);
        }
    });
}, { deep: true });

// API functions
const fetchDashboardData = async () => {
    try {
        loading.value = true;
        const [statsResponse, ordersResponse] = await Promise.all([
            fetch('http://localhost/qls/backend/api/dashboard.php'),
            fetch('http://localhost/qls/backend/api/dashboard.php?type=recent_orders&limit=5')
        ]);
        
        if (statsResponse.ok) stats.value = await statsResponse.json();
        if (ordersResponse.ok) recentOrders.value = await ordersResponse.json();
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    } finally {
        loading.value = false;
    }
};

const fetchBooks = async () => {
    try {
        const response = await fetch('http://localhost/qls/backend/api/books.php');
        if (response.ok) books.value = await response.json();
    } catch (error) {
        console.error('Error fetching books:', error);
    }
};

const fetchCustomers = async () => {
    try {
        const response = await fetch('http://localhost/qls/backend/api/customers.php');
        if (response.ok) customers.value = await response.json();
    } catch (error) {
        console.error('Error fetching customers:', error);
    }
};

const fetchOrders = async () => {
    try {
        const response = await fetch('http://localhost/qls/backend/api/orders.php');
        if (response.ok) orders.value = await response.json();
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
};

const fetchSuppliers = async () => {
    try {
        const response = await fetch('http://localhost/qls/backend/api/suppliers.php');
        if (response.ok) suppliers.value = await response.json();
    } catch (error) {
        console.error('Error fetching suppliers:', error);
    }
};

const fetchPromotions = async () => {
    try {
        const response = await fetch('http://localhost/qls/backend/api/promotions.php');
        if (response.ok) {
            const data = await response.json();
            promotions.value = data.promotions || [];
        }
    } catch (error) {
        console.error('Error fetching promotions:', error);
    }
};

const fetchPaymentMethods = async () => {
    try {
        const response = await fetch('http://localhost/qls/backend/api/payments.php');
        if (response.ok) {
            const data = await response.json();
            paymentMethods.value = data.data || [];
        }
    } catch (error) {
        console.error('Error fetching payment methods:', error);
    }
};

const loadOrderDetails = async () => {
    if (!selectedOrderId.value) {
        orderDetails.value = [];
        return;
    }
    
    try {
        console.log('Loading order details for ID:', selectedOrderId.value);
        const response = await fetch(`http://localhost/qls/backend/api/orders.php?details=${selectedOrderId.value}`);
        console.log('Response status:', response.status);
        
        if (response.ok) {
            const data = await response.json();
            console.log('Order details data:', data);
            orderDetails.value = data;
        } else {
            console.error('Failed to fetch order details:', response.statusText);
            const errorText = await response.text();
            console.error('Error response:', errorText);
        }
    } catch (error) {
        console.error('Error fetching order details:', error);
    }
};

// Search functions
const searchBooks = async () => {
    if (!bookSearch.value.trim()) {
        await fetchBooks();
        return;
    }
    
    try {
        const response = await fetch(`http://localhost/qls/backend/api/books.php?search=${encodeURIComponent(bookSearch.value)}`);
        if (response.ok) books.value = await response.json();
    } catch (error) {
        console.error('Error searching books:', error);
    }
};

const searchCustomers = async () => {
    if (!customerSearch.value.trim()) {
        await fetchCustomers();
        return;
    }
    
    try {
        const response = await fetch(`http://localhost/qls/backend/api/customers.php?search=${encodeURIComponent(customerSearch.value)}`);
        if (response.ok) customers.value = await response.json();
    } catch (error) {
        console.error('Error searching customers:', error);
    }
};

const searchSuppliers = async () => {
    if (!supplierSearch.value.trim()) {
        await fetchSuppliers();
        return;
    }
    
    try {
        const response = await fetch(`http://localhost/qls/backend/api/suppliers.php?search=${encodeURIComponent(supplierSearch.value)}`);
        if (response.ok) suppliers.value = await response.json();
    } catch (error) {
        console.error('Error searching suppliers:', error);
    }
};

const searchPromotions = async () => {
    if (!promotionSearch.value.trim()) {
        await fetchPromotions();
        return;
    }
    
    try {
        const response = await fetch(`http://localhost/qls/backend/api/promotions.php?search=${encodeURIComponent(promotionSearch.value)}`);
        if (response.ok) {
            const data = await response.json();
            promotions.value = data.promotions || [];
        }
    } catch (error) {
        console.error('Error searching promotions:', error);
    }
};

const validatePromotion = async () => {
    if (!orderForm.value.PromotionCode.trim()) {
        promotionValidation.value = null;
        return;
    }
    
    try {
        validatingPromotion.value = true;
        const validItems = orderForm.value.items.filter(item => 
            item.BookID && parseInt(item.Quantity) > 0
        );
        
        const orderAmount = validItems.reduce((total, item) => 
            total + (parseInt(item.Quantity) * parseFloat(item.Price)), 0
        );
        
        const customerId = orderForm.value.customerType === 'existing' 
            ? orderForm.value.CustomerID 
            : 0; // Will be set after customer creation
        
        const response = await fetch(`http://localhost/qls/backend/api/promotions.php?action=validate&code=${encodeURIComponent(orderForm.value.PromotionCode)}&customerId=${customerId}&amount=${orderAmount}&items=${encodeURIComponent(JSON.stringify(validItems))}`);
        
        if (response.ok) {
            promotionValidation.value = await response.json();
        } else {
            promotionValidation.value = { valid: false, message: 'Lỗi khi kiểm tra mã khuyến mãi' };
        }
    } catch (error) {
        console.error('Error validating promotion:', error);
        promotionValidation.value = { valid: false, message: 'Lỗi khi kiểm tra mã khuyến mãi' };
    } finally {
        validatingPromotion.value = false;
    }
};

// Book modal functions
const openBookModal = () => {
    isEditingBook.value = false;
    resetBookForm();
    showBookModal.value = true;
};

const editBook = (book) => {
    isEditingBook.value = true;
    bookForm.value = {
        BookID: book.BookID,
        Title: book.Title,
        Author: book.Author,
        Genre: book.Genre,
        Price: book.Price,
        InputQuantity: book.InputQuantity || book.Stock || 0,
        OutputQuantity: book.OutputQuantity || 0,
        SupplierID: book.SupplierID
    };
    showBookModal.value = true;
};

const closeBookModal = () => {
    showBookModal.value = false;
    resetBookForm();
};

const resetBookForm = () => {
    bookForm.value = {
        BookID: null,
        Title: '',
        Author: '',
        Genre: '',
        Price: '',
        InputQuantity: '',
        OutputQuantity: '',
        SupplierID: ''
    };
};

const saveBook = async () => {
    try {
        savingBook.value = true;
        
        const bookData = {
            Title: bookForm.value.Title,
            Author: bookForm.value.Author,
            Genre: bookForm.value.Genre,
            Price: parseFloat(bookForm.value.Price),
            InputQuantity: parseInt(bookForm.value.InputQuantity) || 0,
            OutputQuantity: parseInt(bookForm.value.OutputQuantity) || 0,
            SupplierID: parseInt(bookForm.value.SupplierID)
        };

        let response;
        if (isEditingBook.value) {
            // Update existing book
            response = await fetch(`http://localhost/qls/backend/api/books.php`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ BookID: bookForm.value.BookID, ...bookData })
            });
        } else {
            // Create new book
            response = await fetch('http://localhost/qls/backend/api/books.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(bookData)
            });
        }

        if (response.ok) {
            await fetchBooks();
            closeBookModal();
            alert(isEditingBook.value ? 'Cập nhật sách thành công!' : 'Thêm sách thành công!');
        } else {
            const errorData = await response.json();
            alert(`Lỗi: ${errorData.message || 'Có lỗi xảy ra'}`);
        }
    } catch (error) {
        console.error('Error saving book:', error);
        alert('Lỗi khi lưu sách');
    } finally {
        savingBook.value = false;
    }
};

const deleteBook = async (bookId) => {
    if (!confirm('Bạn có chắc muốn xóa sách này?')) return;
    
    try {
        const response = await fetch('http://localhost/qls/backend/api/books.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ BookID: bookId })
        });
        
        if (response.ok) {
            await fetchBooks();
            alert('Xóa sách thành công!');
        }
    } catch (error) {
        console.error('Error deleting book:', error);
        alert('Lỗi khi xóa sách');
    }
};

// Customer modal functions
const openCustomerModal = () => {
    isEditingCustomer.value = false;
    resetCustomerForm();
    showCustomerModal.value = true;
};

const editCustomer = (customer) => {
    isEditingCustomer.value = true;
    customerForm.value = {
        CustomerID: customer.CustomerID,
        Name: customer.Name,
        Email: customer.Email,
        Phone: customer.Phone
    };
    showCustomerModal.value = true;
};

const closeCustomerModal = () => {
    showCustomerModal.value = false;
    resetCustomerForm();
};

const resetCustomerForm = () => {
    customerForm.value = {
        CustomerID: null,
        Name: '',
        Email: '',
        Phone: ''
    };
};

const saveCustomer = async () => {
    try {
        savingCustomer.value = true;
        
        const customerData = {
            Name: customerForm.value.Name,
            Email: customerForm.value.Email,
            Phone: customerForm.value.Phone
        };

        let response;
        if (isEditingCustomer.value) {
            // Update existing customer
            response = await fetch(`http://localhost/qls/backend/api/customers.php`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ CustomerID: customerForm.value.CustomerID, ...customerData })
            });
        } else {
            // Create new customer
            response = await fetch('http://localhost/qls/backend/api/customers.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(customerData)
            });
        }

        if (response.ok) {
            await fetchCustomers();
            closeCustomerModal();
            alert(isEditingCustomer.value ? 'Cập nhật khách hàng thành công!' : 'Thêm khách hàng thành công!');
        } else {
            const errorData = await response.json();
            alert(`Lỗi: ${errorData.message || 'Có lỗi xảy ra'}`);
        }
    } catch (error) {
        console.error('Error saving customer:', error);
        alert('Lỗi khi lưu khách hàng');
    } finally {
        savingCustomer.value = false;
    }
};

const deleteCustomer = async (customerId) => {
    if (!confirm('Bạn có chắc muốn xóa khách hàng này?')) return;
    
    try {
        const response = await fetch('http://localhost/qls/backend/api/customers.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ CustomerID: customerId })
        });
        
        if (response.ok) {
            await fetchCustomers();
            alert('Xóa khách hàng thành công!');
        }
    } catch (error) {
        console.error('Error deleting customer:', error);
        alert('Lỗi khi xóa khách hàng');
    }
};

// Order modal functions
const openOrderModal = () => {
    resetOrderForm();
    showOrderModal.value = true;
};

const closeOrderModal = () => {
    showOrderModal.value = false;
    resetOrderForm();
};

const resetOrderForm = () => {
    orderForm.value = {
        customerType: 'existing',
        CustomerID: '',
        newCustomer: {
            Name: '',
            Email: '',
            Phone: ''
        },
        items: [],
        PromotionCode: '',
        PaymentMethodID: '',
        SubTotal: 0,
        DiscountAmount: 0,
        TotalAmount: 0
    };
    promotionValidation.value = null;
};

const handleCustomerTypeChange = () => {
    if (orderForm.value.customerType === 'existing') {
        orderForm.value.CustomerID = '';
    } else {
        orderForm.value.newCustomer = {
            Name: '',
            Email: '',
            Phone: ''
        };
    }
};

const addOrderItem = () => {
    orderForm.value.items.push({
        BookID: '',
        Quantity: 0,
        Price: 0,
        Total: 0,
        bookSearch: '',
        showBookDropdown: false,
        filteredBooks: []
    });
};

const removeOrderItem = (index) => {
    orderForm.value.items.splice(index, 1);
};

// Book search functions for order items
const searchBooksInOrder = (index, searchTerm) => {
    const item = orderForm.value.items[index];
    item.bookSearch = searchTerm;
    
    if (!searchTerm.trim()) {
        item.filteredBooks = [];
        return;
    }
    
    const filtered = books.value.filter(book => 
        book.Title.toLowerCase().includes(searchTerm.toLowerCase()) ||
        book.Author.toLowerCase().includes(searchTerm.toLowerCase()) ||
        book.Genre.toLowerCase().includes(searchTerm.toLowerCase())
    );
    
    item.filteredBooks = filtered.slice(0, 10); // Limit to 10 results
};

const showBookDropdown = (index) => {
    const item = orderForm.value.items[index];
    item.showBookDropdown = true;
};

const hideBookDropdown = (index) => {
    // Delay hiding to allow click on dropdown items
    setTimeout(() => {
        const item = orderForm.value.items[index];
        if (item) {
            item.showBookDropdown = false;
        }
    }, 300);
};

const selectBook = (index, book) => {
    const item = orderForm.value.items[index];
    item.BookID = book.BookID;
    item.bookSearch = book.Title;
    item.Price = parseFloat(book.Price) || 0;
    item.showBookDropdown = false;
    item.filteredBooks = [];
    
    // Tự động đặt số lượng thành 1 khi chọn sách
    const stock = book.Stock || 0;
    if (stock === 0) {
        item.Quantity = 0;
        alert('Sách này đã hết hàng!');
    } else if (stock >= 1) {
        item.Quantity = 1;
    } else {
        item.Quantity = stock;
        alert(`Số lượng đã được đặt thành ${stock} do tồn kho hạn chế`);
    }
    
    // Cập nhật tổng tiền
    updateItemTotal(index);
};

const clearBookSelection = (index) => {
    const item = orderForm.value.items[index];
    item.BookID = '';
    item.bookSearch = '';
    item.Price = 0;
    item.Quantity = 0;
    item.showBookDropdown = false;
    item.filteredBooks = [];
    updateItemTotal(index);
};

// Handle keyboard navigation
const handleBookInputKeydown = (index, event) => {
    const item = orderForm.value.items[index];
    
    if (event.key === 'Enter') {
        event.preventDefault();
        if (item.filteredBooks.length > 0) {
            selectBook(index, item.filteredBooks[0]);
        } else if (books.value.length > 0) {
            selectBook(index, books.value[0]);
        }
    } else if (event.key === 'Escape') {
        item.showBookDropdown = false;
        event.target.blur();
    }
};

const updateItemPrice = (index) => {
    const item = orderForm.value.items[index];
    const selectedBook = books.value.find(book => book.BookID == item.BookID);
    if (selectedBook) {
        item.Price = selectedBook.Price;
        updateItemTotal(index);
    }
};

const updateItemTotal = (index) => {
    const item = orderForm.value.items[index];
    const price = parseFloat(item.Price) || 0;
    const quantity = parseInt(item.Quantity) || 0;
    item.Total = price * quantity;
    
    // Đảm bảo giá trị được cập nhật trong template
    item.Price = price;
    item.Quantity = quantity;
};

// Hàm để cập nhật tổng tiền khi thay đổi số lượng
const handleQuantityChange = (index) => {
    updateItemTotal(index);
    // Thêm hiệu ứng visual feedback
    const item = orderForm.value.items[index];
    if (item.Quantity > 0 && item.Price > 0) {
        // Có thể thêm animation hoặc highlight ở đây nếu cần
        console.log(`Cập nhật item ${index}: ${item.Quantity} x ${item.Price} = ${item.Total}`);
    }
};

const saveOrder = async () => {
    try {
        savingOrder.value = true;
        
        // Kiểm tra tồn kho trước khi tạo đơn hàng
        const stockErrors = [];
        orderForm.value.items.forEach((item, index) => {
            if (item.BookID) {
                const stock = getSelectedBookStock(index);
                const quantity = parseInt(item.Quantity) || 0;
                if (quantity > stock) {
                    const bookTitle = getSelectedBookTitle(index);
                    stockErrors.push(`${bookTitle}: Đặt ${quantity} nhưng chỉ còn ${stock} trong kho`);
                }
            }
        });
        
        if (stockErrors.length > 0) {
            alert('Lỗi tồn kho:\n' + stockErrors.join('\n'));
            savingOrder.value = false;
            return;
        }
        
        let customerId = orderForm.value.CustomerID;
        
        // Nếu là khách hàng mới, tạo khách hàng trước
        if (orderForm.value.customerType === 'new') {
            const customerData = {
                Name: orderForm.value.newCustomer.Name,
                Email: orderForm.value.newCustomer.Email,
                Phone: orderForm.value.newCustomer.Phone
            };
            
            const customerResponse = await fetch('http://localhost/qls/backend/api/customers.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(customerData)
            });
            
            if (!customerResponse.ok) {
                const errorData = await customerResponse.json();
                throw new Error(`Lỗi tạo khách hàng: ${errorData.message || 'Có lỗi xảy ra'}`);
            }
            
            const customerResult = await customerResponse.json();
            customerId = customerResult.id;
        }
        
        // Tạo đơn hàng (chỉ bao gồm items có số lượng > 0)
        const validItems = orderForm.value.items.filter(item => 
            item.BookID && parseInt(item.Quantity) > 0
        );
        
        if (validItems.length === 0) {
            alert('Vui lòng thêm ít nhất một sản phẩm với số lượng > 0');
            savingOrder.value = false;
            return;
        }
        
        const orderData = {
            CustomerID: customerId,
            OrderDate: new Date().toISOString().split('T')[0],
            PromotionCode: orderForm.value.PromotionCode,
            PaymentMethodID: orderForm.value.PaymentMethodID,
            TotalAmount: orderTotal.value,
            items: validItems.map(item => ({
                BookID: item.BookID,
                Quantity: parseInt(item.Quantity),
                Price: parseFloat(item.Price)
            }))
        };
        
        const orderResponse = await fetch('http://localhost/qls/backend/api/orders.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(orderData)
        });
        
        if (orderResponse.ok) {
            await fetchOrders();
            await fetchCustomers(); // Refresh customers list if new customer was created
            closeOrderModal();
            alert('Tạo đơn hàng thành công!');
        } else {
            const errorData = await orderResponse.json();
            throw new Error(`Lỗi tạo đơn hàng: ${errorData.message || 'Có lỗi xảy ra'}`);
        }
    } catch (error) {
        console.error('Error saving order:', error);
        alert(`Lỗi khi tạo đơn hàng: ${error.message}`);
    } finally {
        savingOrder.value = false;
    }
};

const viewOrderDetails = (orderId) => {
    selectedOrderId.value = orderId;
    loadOrderDetails();
    activeTab.value = 'orderDetails';
};

const deleteOrder = async (orderId) => {
    if (!confirm('Bạn có chắc muốn xóa đơn hàng này?')) return;
    
    try {
        const response = await fetch('http://localhost/qls/backend/api/orders.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ OrderID: orderId })
        });
        
        if (response.ok) {
            await fetchOrders();
            alert('Xóa đơn hàng thành công!');
        }
    } catch (error) {
        console.error('Error deleting order:', error);
        alert('Lỗi khi xóa đơn hàng');
    }
};

// Supplier modal functions
const openSupplierModal = () => {
    isEditingSupplier.value = false;
    resetSupplierForm();
    showSupplierModal.value = true;
};

const editSupplier = (supplier) => {
    isEditingSupplier.value = true;
    supplierForm.value = {
        SupplierID: supplier.SupplierID,
        Name: supplier.Name,
        Address: supplier.Address,
        Phone: supplier.Phone
    };
    showSupplierModal.value = true;
};

const closeSupplierModal = () => {
    showSupplierModal.value = false;
    resetSupplierForm();
};

const resetSupplierForm = () => {
    supplierForm.value = {
        SupplierID: null,
        Name: '',
        Address: '',
        Phone: ''
    };
};

const saveSupplier = async () => {
    try {
        savingSupplier.value = true;
        
        const supplierData = {
            Name: supplierForm.value.Name,
            Address: supplierForm.value.Address,
            Phone: supplierForm.value.Phone
        };

        let response;
        if (isEditingSupplier.value) {
            // Update existing supplier
            response = await fetch(`http://localhost/qls/backend/api/suppliers.php`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ SupplierID: supplierForm.value.SupplierID, ...supplierData })
            });
        } else {
            // Create new supplier
            response = await fetch('http://localhost/qls/backend/api/suppliers.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(supplierData)
            });
        }

        if (response.ok) {
            await fetchSuppliers();
            closeSupplierModal();
            alert(isEditingSupplier.value ? 'Cập nhật nhà cung cấp thành công!' : 'Thêm nhà cung cấp thành công!');
        } else {
            const errorData = await response.json();
            alert(`Lỗi: ${errorData.message || 'Có lỗi xảy ra'}`);
        }
    } catch (error) {
        console.error('Error saving supplier:', error);
        alert('Lỗi khi lưu nhà cung cấp');
    } finally {
        savingSupplier.value = false;
    }
};

const deleteSupplier = async (supplierId) => {
    if (!confirm('Bạn có chắc muốn xóa nhà cung cấp này?')) return;
    
    try {
        const response = await fetch('http://localhost/qls/backend/api/suppliers.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ SupplierID: supplierId })
        });
        
        if (response.ok) {
            await fetchSuppliers();
            alert('Xóa nhà cung cấp thành công!');
        }
    } catch (error) {
        console.error('Error deleting supplier:', error);
        alert('Lỗi khi xóa nhà cung cấp');
    }
};

// Promotion management functions
const openPromotionModal = () => {
    isEditingPromotion.value = false;
    resetPromotionForm();
    showPromotionModal.value = true;
};

const editPromotion = (promotion) => {
    isEditingPromotion.value = true;
    promotionForm.value = {
        PromotionID: promotion.PromotionID,
        PromotionCode: promotion.PromotionCode,
        PromotionName: promotion.PromotionName,
        Description: promotion.Description || '',
        DiscountType: promotion.DiscountType,
        DiscountValue: promotion.DiscountValue,
        MinimumOrderAmount: promotion.MinimumOrderAmount || '',
        MaximumDiscount: promotion.MaximumDiscount || '',
        StartDate: promotion.StartDate ? new Date(promotion.StartDate).toISOString().split('T')[0] : '',
        EndDate: promotion.EndDate ? new Date(promotion.EndDate).toISOString().split('T')[0] : '',
        IsActive: promotion.IsActive,
        UsageLimit: promotion.UsageLimit || '',
        TargetType: 'all' // Default value, will be updated based on targets
    };
    showPromotionModal.value = true;
};

const closePromotionModal = () => {
    showPromotionModal.value = false;
    resetPromotionForm();
};

const resetPromotionForm = () => {
    promotionForm.value = {
        PromotionID: null,
        PromotionCode: '',
        PromotionName: '',
        Description: '',
        DiscountType: '',
        DiscountValue: '',
        MinimumOrderAmount: '',
        MaximumDiscount: '',
        StartDate: '',
        EndDate: '',
        IsActive: true,
        UsageLimit: '',
        TargetType: 'all'
    };
};

const savePromotion = async () => {
    try {
        savingPromotion.value = true;
        
        // Validate date formats
        if (!promotionForm.value.StartDate || !promotionForm.value.EndDate) {
            alert('Vui lòng nhập đầy đủ ngày bắt đầu và ngày kết thúc');
            return;
        }
        
        // Ensure dates are in YYYY-MM-DD format
        const startDate = new Date(promotionForm.value.StartDate).toISOString().split('T')[0];
        const endDate = new Date(promotionForm.value.EndDate).toISOString().split('T')[0];
        
        // Validate that end date is not before start date
        if (new Date(endDate) < new Date(startDate)) {
            alert('Ngày kết thúc không thể trước ngày bắt đầu');
            return;
        }
        
        const promotionData = {
            PromotionCode: promotionForm.value.PromotionCode,
            PromotionName: promotionForm.value.PromotionName,
            Description: promotionForm.value.Description,
            DiscountType: promotionForm.value.DiscountType,
            DiscountValue: parseFloat(promotionForm.value.DiscountValue),
            MinimumOrderAmount: promotionForm.value.MinimumOrderAmount ? parseFloat(promotionForm.value.MinimumOrderAmount) : 0,
            MaximumDiscount: promotionForm.value.MaximumDiscount ? parseFloat(promotionForm.value.MaximumDiscount) : null,
            StartDate: startDate,
            EndDate: endDate,
            IsActive: promotionForm.value.IsActive,
            UsageLimit: promotionForm.value.UsageLimit ? parseInt(promotionForm.value.UsageLimit) : null,
            TargetType: promotionForm.value.TargetType
        };

        let response;
        if (isEditingPromotion.value) {
            // Update existing promotion
            response = await fetch(`http://localhost/qls/backend/api/promotions.php`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ PromotionID: promotionForm.value.PromotionID, ...promotionData })
            });
        } else {
            // Create new promotion
            response = await fetch('http://localhost/qls/backend/api/promotions.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(promotionData)
            });
        }

        if (response.ok) {
            await fetchPromotions();
            closePromotionModal();
            alert(isEditingPromotion.value ? 'Cập nhật khuyến mãi thành công!' : 'Thêm khuyến mãi thành công!');
        } else {
            const errorData = await response.json();
            alert(`Lỗi: ${errorData.message || 'Có lỗi xảy ra'}`);
        }
    } catch (error) {
        console.error('Error saving promotion:', error);
        alert('Lỗi khi lưu khuyến mãi');
    } finally {
        savingPromotion.value = false;
    }
};

const deletePromotion = async (promotionId) => {
    if (!confirm('Bạn có chắc muốn xóa khuyến mãi này?')) return;
    
    try {
        const response = await fetch('http://localhost/qls/backend/api/promotions.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ PromotionID: promotionId })
        });
        
        if (response.ok) {
            await fetchPromotions();
            alert('Xóa khuyến mãi thành công!');
        }
    } catch (error) {
        console.error('Error deleting promotion:', error);
        alert('Lỗi khi xóa khuyến mãi');
    }
};



// Dashboard interaction functions
const refreshData = async () => {
    try {
        await Promise.all([
            fetchDashboardData(),
            fetchBooks(),
            fetchCustomers(),
            fetchOrders(),
            fetchSuppliers(),
            fetchPromotions()
        ]);
        alert('Đã làm mới dữ liệu thành công!');
    } catch (error) {
        console.error('Error refreshing data:', error);
        alert('Lỗi khi làm mới dữ liệu');
    }
};

const exportReport = () => {
    // Tạo báo cáo dữ liệu
    const reportData = {
        timestamp: new Date().toISOString(),
        overview: stats.value.overview,
        revenueStats: stats.value.revenueStats,
        topBooks: stats.value.topBooks,
        topCustomers: stats.value.topCustomers,
        lowStockBooks: stats.value.lowStockBooks
    };
    
    // Tạo file JSON để download
    const dataStr = JSON.stringify(reportData, null, 2);
    const dataBlob = new Blob([dataStr], { type: 'application/json' });
    const url = URL.createObjectURL(dataBlob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `qls-report-${new Date().toISOString().split('T')[0]}.json`;
    link.click();
    URL.revokeObjectURL(url);
    
    alert('Đã xuất báo cáo thành công!');
};

const showInsights = () => {
    // Hiển thị thông tin chi tiết và phân tích
    const insights = {
        totalRevenue: stats.value.overview?.TotalRevenue || 0,
        totalOrders: stats.value.overview?.TotalOrders || 0,
        totalBooks: stats.value.overview?.TotalBooks || 0,
        totalCustomers: stats.value.overview?.TotalCustomers || 0,
        lowStockAlert: stats.value.overview?.LowStockBooks || 0,
        averageOrderValue: stats.value.overview?.TotalRevenue > 0 && stats.value.overview?.TotalOrders > 0 
            ? stats.value.overview.TotalRevenue / stats.value.overview.TotalOrders 
            : 0
    };
    
    const message = `
📊 THÔNG TIN CHI TIẾT HỆ THỐNG QLS

💰 Tổng doanh thu: ${formatCurrency(insights.totalRevenue)}
📦 Tổng đơn hàng: ${insights.totalOrders}
📚 Tổng sách: ${insights.totalBooks}
👥 Tổng khách hàng: ${insights.totalCustomers}
⚠️ Sách tồn kho thấp: ${insights.lowStockAlert}
📈 Giá trị đơn hàng trung bình: ${formatCurrency(insights.averageOrderValue)}

🎯 KHUYẾN NGHỊ:
${insights.lowStockAlert > 0 ? '• Cần nhập thêm sách cho các đầu sách tồn kho thấp' : '• Tồn kho đang ở mức ổn định'}
${insights.totalCustomers > 0 ? '• Tiếp tục phát triển khách hàng mới' : '• Cần tăng cường marketing để thu hút khách hàng'}
${insights.averageOrderValue > 0 ? '• Tập trung vào cross-selling để tăng giá trị đơn hàng' : '• Cần cải thiện chiến lược bán hàng'}
    `;
    
    alert(message);
};

// Initialize
onMounted(() => {
    updateDateTime();
    setInterval(updateDateTime, 1000);
    fetchDashboardData();
    fetchBooks();
    fetchCustomers();
    fetchOrders();
    fetchSuppliers();
    fetchPromotions();
    fetchPaymentMethods();
});

const updateDateTime = () => {
    const now = new Date();
    currentDate.value = now.toLocaleDateString('vi-VN');
    currentTime.value = now.toLocaleTimeString('vi-VN');
};
</script>

<style scoped>
/* Custom scrollbar styles for horizontal scrolling */
.overflow-x-auto {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e0 #f7fafc;
}

.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f7fafc;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

/* Ensure table cells don't wrap and maintain consistent width */
.overflow-x-auto table {
    min-width: 1200px; /* Minimum width to ensure all columns are visible */
}

.overflow-x-auto th,
.overflow-x-auto td {
    white-space: nowrap;
    min-width: 120px; /* Minimum column width */
}

/* Specific column widths for better layout */
.overflow-x-auto th:nth-child(1), /* Mã */
.overflow-x-auto td:nth-child(1) {
    min-width: 100px;
}

.overflow-x-auto th:nth-child(2), /* Tên khuyến mãi */
.overflow-x-auto td:nth-child(2) {
    min-width: 200px;
}

.overflow-x-auto th:nth-child(3), /* Loại giảm giá */
.overflow-x-auto td:nth-child(3) {
    min-width: 120px;
}

.overflow-x-auto th:nth-child(4), /* Giá trị */
.overflow-x-auto td:nth-child(4) {
    min-width: 100px;
}

.overflow-x-auto th:nth-child(5), /* Điều kiện */
.overflow-x-auto td:nth-child(5) {
    min-width: 150px;
}

.overflow-x-auto th:nth-child(6), /* Thời gian */
.overflow-x-auto td:nth-child(6) {
    min-width: 150px;
}

.overflow-x-auto th:nth-child(7), /* Trạng thái */
.overflow-x-auto td:nth-child(7) {
    min-width: 100px;
}

.overflow-x-auto th:nth-child(8), /* Sử dụng */
.overflow-x-auto td:nth-child(8) {
    min-width: 100px;
}

.overflow-x-auto th:nth-child(9), /* Thao tác */
.overflow-x-auto td:nth-child(9) {
    min-width: 150px;
}

/* Smooth scrolling animation */
.overflow-x-auto {
    scroll-behavior: smooth;
}

/* Hover effect for better UX */
.overflow-x-auto:hover {
    scrollbar-color: #a0aec0 #f7fafc;
}
</style>

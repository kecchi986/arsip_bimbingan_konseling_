import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { Users, FileText, BookOpen, Plus } from 'lucide-react';

interface DashboardStats {
  totalStudents: number;
  totalRecords: number;
  totalServices: number;
  recentRecords: any[];
}

const Dashboard: React.FC = () => {
  const [stats, setStats] = useState<DashboardStats>({
    totalStudents: 0,
    totalRecords: 0,
    totalServices: 0,
    recentRecords: [],
  });
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetchDashboardData();
  }, []);

  const fetchDashboardData = async () => {
    try {
      const [studentsRes, recordsRes, servicesRes] = await Promise.all([
        axios.get('/api/students'),
        axios.get('/api/counseling-records'),
        axios.get('/api/services'),
      ]);

      setStats({
        totalStudents: studentsRes.data.length,
        totalRecords: recordsRes.data.length,
        totalServices: servicesRes.data.length,
        recentRecords: recordsRes.data.slice(0, 5),
      });
    } catch (error) {
      console.error('Error fetching dashboard data:', error);
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-gradient-to-br from-blue-100 via-white to-blue-300 p-4 md:p-8">
      <div className="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h1 className="text-3xl font-extrabold text-gray-900 flex items-center gap-3">
            <span>Dashboard</span>
            <span className="inline-block bg-blue-200 p-2 rounded-full">
              <svg width="32" height="32" fill="none" viewBox="0 0 24 24"><rect width="24" height="24" rx="12" fill="#2563eb"/><path d="M12 13a4 4 0 100-8 4 4 0 000 8zM4 20a8 8 0 1116 0H4z" fill="#fff"/></svg>
            </span>
          </h1>
          <p className="text-gray-600 mt-1">Selamat datang di sistem arsip bimbingan konseling</p>
        </div>
      </div>

      {/* Stats Cards */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div className="bg-gradient-to-br from-blue-400 to-blue-600 text-white shadow-lg rounded-2xl p-6 flex items-center gap-4 hover:scale-105 transition-transform">
          <Users className="h-12 w-12 opacity-80" />
          <div>
            <div className="text-lg font-bold">{stats.totalStudents}</div>
            <div className="text-sm opacity-90">Total Siswa</div>
          </div>
        </div>
        <div className="bg-gradient-to-br from-green-400 to-green-600 text-white shadow-lg rounded-2xl p-6 flex items-center gap-4 hover:scale-105 transition-transform">
          <FileText className="h-12 w-12 opacity-80" />
          <div>
            <div className="text-lg font-bold">{stats.totalRecords}</div>
            <div className="text-sm opacity-90">Total Rekaman</div>
          </div>
        </div>
        <div className="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white shadow-lg rounded-2xl p-6 flex items-center gap-4 hover:scale-105 transition-transform">
          <BookOpen className="h-12 w-12 opacity-80" />
          <div>
            <div className="text-lg font-bold">{stats.totalServices}</div>
            <div className="text-sm opacity-90">Total Layanan</div>
          </div>
        </div>
      </div>

      {/* Quick Actions */}
      <div className="bg-white/90 shadow rounded-2xl mb-8 p-6">
        <h3 className="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <Link
            to="/counseling-records"
            className="group bg-blue-100 hover:bg-blue-200 p-6 border border-blue-200 rounded-xl flex flex-col items-center transition"
          >
            <Plus className="h-8 w-8 text-blue-600 mb-2" />
            <span className="font-semibold text-blue-700">Tambah Rekaman</span>
            <span className="text-xs text-blue-500 mt-1">Buat rekaman kegiatan konseling baru</span>
          </Link>
          <Link
            to="/students"
            className="group bg-green-100 hover:bg-green-200 p-6 border border-green-200 rounded-xl flex flex-col items-center transition"
          >
            <Users className="h-8 w-8 text-green-600 mb-2" />
            <span className="font-semibold text-green-700">Kelola Siswa</span>
            <span className="text-xs text-green-500 mt-1">Tambah atau edit data siswa</span>
          </Link>
          <Link
            to="/services"
            className="group bg-yellow-100 hover:bg-yellow-200 p-6 border border-yellow-200 rounded-xl flex flex-col items-center transition"
          >
            <BookOpen className="h-8 w-8 text-yellow-600 mb-2" />
            <span className="font-semibold text-yellow-700">Kelola Layanan</span>
            <span className="text-xs text-yellow-500 mt-1">Tambah atau edit layanan</span>
          </Link>
        </div>
      </div>

      {/* Recent Records */}
      <div className="bg-white/90 shadow rounded-2xl p-6">
        <h3 className="text-lg font-bold text-gray-900 mb-4">Rekaman Terbaru</h3>
        {stats.recentRecords.length === 0 ? (
          <div className="text-gray-500 text-center py-8">Belum ada rekaman</div>
        ) : (
          <ul className="divide-y divide-gray-200">
            {stats.recentRecords.map((rec: any, idx: number) => (
              <li key={rec.id || idx} className="py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div>
                  <div className="font-semibold text-blue-700">{rec.activity}</div>
                  <div className="text-xs text-gray-500">{rec.date} &bull; {rec.student_name}</div>
                  <div className="text-xs text-gray-400">{rec.location} &bull; {rec.description}</div>
                </div>
                <Link to="/counseling-records" className="text-xs text-blue-600 hover:underline">Lihat Detail</Link>
              </li>
            ))}
          </ul>
        )}
      </div>
    </div>
  );
};

export default Dashboard; 
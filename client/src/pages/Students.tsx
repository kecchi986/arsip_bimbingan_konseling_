import React, { useState, useEffect } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { Plus, Search, Edit, Trash2, Eye, X } from 'lucide-react';

interface Student {
  id: number;
  nis: string;
  name: string;
  grade: string;
  major: string;
  room: string;
}

const Students: React.FC = () => {
  const [students, setStudents] = useState<Student[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [editingStudent, setEditingStudent] = useState<Student | null>(null);
  const [viewingStudent, setViewingStudent] = useState<Student | null>(null);
  const [formData, setFormData] = useState({
    nis: '',
    name: '',
    grade: '',
    major: '',
    room: '',
  });

  useEffect(() => {
    fetchStudents();
  }, [searchTerm]);

  const fetchStudents = async () => {
    try {
      const response = await axios.get(`/api/students${searchTerm ? `?search=${searchTerm}` : ''}`);
      setStudents(response.data);
    } catch (error) {
      toast.error('Gagal memuat data siswa');
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      if (editingStudent) {
        await axios.put(`/api/students/${editingStudent.id}`, formData);
        toast.success('Data siswa berhasil diperbarui');
      } else {
        await axios.post('/api/students', formData);
        toast.success('Data siswa berhasil ditambahkan');
      }
      
      setShowModal(false);
      setEditingStudent(null);
      resetForm();
      fetchStudents();
    } catch (error: any) {
      const message = error.response?.data?.error || 'Terjadi kesalahan';
      toast.error(message);
    }
  };

  const handleEdit = (student: Student) => {
    setEditingStudent(student);
    setFormData({
      nis: student.nis,
      name: student.name,
      grade: student.grade,
      major: student.major,
      room: student.room,
    });
    setShowModal(true);
  };

  const handleDelete = async (id: number) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus siswa ini?')) {
      try {
        await axios.delete(`/api/students/${id}`);
        toast.success('Siswa berhasil dihapus');
        fetchStudents();
      } catch (error) {
        toast.error('Gagal menghapus siswa');
      }
    }
  };

  const resetForm = () => {
    setFormData({
      nis: '',
      name: '',
      grade: '',
      major: '',
      room: '',
    });
  };

  const openAddModal = () => {
    setEditingStudent(null);
    resetForm();
    setShowModal(true);
  };

  if (loading) {
    return (
      <div className="flex items-center justify-center h-64">
        <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600"></div>
      </div>
    );
  }

  return (
    <div>
      {/* Header & Tambah Siswa */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h1 className="text-xl font-bold mb-2 sm:mb-0">Data Siswa</h1>
        <button
          onClick={openAddModal}
          className="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow flex items-center"
        >
          <Plus className="h-5 w-5 mr-2" /> Tambah Siswa
        </button>
      </div>

      {/* Search */}
      <div className="mb-6 flex justify-end">
        <div className="relative w-full sm:w-80">
          <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <Search className="h-5 w-5 text-gray-400" />
          </div>
          <input
            type="text"
            placeholder="Cari siswa..."
            className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
      </div>

      {/* Students Table */}
      <div className="bg-white shadow overflow-hidden sm:rounded-md">
        <table className="min-w-full border border-gray-300">
          <thead className="bg-gray-100">
            <tr>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">No</th>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">NIS</th>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">Nama</th>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">Tingkat</th>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">Jurusan</th>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">Ruangan</th>
              <th className="border px-4 py-2 text-xs font-bold text-gray-700">Aksi</th>
            </tr>
          </thead>
          <tbody>
            {students.map((student, idx) => (
              <tr key={student.id} className="hover:bg-gray-50">
                <td className="border px-4 py-2 text-sm text-center">{idx + 1}</td>
                <td className="border px-4 py-2 text-sm">{student.nis}</td>
                <td className="border px-4 py-2 text-sm">{student.name}</td>
                <td className="border px-4 py-2 text-sm">{student.grade}</td>
                <td className="border px-4 py-2 text-sm">{student.major}</td>
                <td className="border px-4 py-2 text-sm">{student.room}</td>
                <td className="border px-4 py-2 text-sm text-center">
                  <button
                    onClick={() => setViewingStudent(student)}
                    className="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs mr-1"
                  >
                    View
                  </button>
                  <button
                    onClick={() => handleEdit(student)}
                    className="bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-1 rounded text-xs mr-1"
                  >
                    Edit
                  </button>
                  <button
                    onClick={() => handleDelete(student.id)}
                    className="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        {students.length === 0 && (
          <div className="text-center py-12">
            <p className="text-gray-500">Tidak ada data siswa</p>
          </div>
        )}
      </div>

      {/* Add/Edit Modal */}
      {showModal && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div className="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div className="mt-3">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-medium text-gray-900">
                  {editingStudent ? 'Edit Siswa' : 'Tambah Siswa'}
                </h3>
                <button
                  onClick={() => setShowModal(false)}
                  className="text-gray-400 hover:text-gray-600"
                >
                  <X className="h-6 w-6" />
                </button>
              </div>
              <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700">NIS</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.nis}
                    onChange={(e) => setFormData({ ...formData, nis: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Nama</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Tingkat</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.grade}
                    onChange={(e) => setFormData({ ...formData, grade: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Jurusan</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.major}
                    onChange={(e) => setFormData({ ...formData, major: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Ruangan</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.room}
                    onChange={(e) => setFormData({ ...formData, room: e.target.value })}
                  />
                </div>
                <div className="flex justify-end space-x-3 pt-4">
                  <button
                    type="button"
                    onClick={() => setShowModal(false)}
                    className="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                  >
                    Batal
                  </button>
                  <button
                    type="submit"
                    className="px-4 py-2 text-sm font-medium text-white bg-primary-600 border border-transparent rounded-md hover:bg-primary-700"
                  >
                    {editingStudent ? 'Update' : 'Simpan'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}

      {/* View Modal */}
      {viewingStudent && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div className="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div className="mt-3">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-medium text-gray-900">Detail Siswa</h3>
                <button
                  onClick={() => setViewingStudent(null)}
                  className="text-gray-400 hover:text-gray-600"
                >
                  <X className="h-6 w-6" />
                </button>
              </div>
              <div className="space-y-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700">NIS</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingStudent.nis}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Nama</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingStudent.name}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Tingkat</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingStudent.grade}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Jurusan</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingStudent.major}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Ruangan</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingStudent.room}</p>
                </div>
                <div className="flex justify-end pt-4">
                  <button
                    onClick={() => setViewingStudent(null)}
                    className="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50"
                  >
                    Tutup
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Students; 
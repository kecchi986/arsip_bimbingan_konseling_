import React, { useState, useEffect } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { Plus, Search, Edit, Trash2, Eye, Printer, X } from 'lucide-react';

interface Student {
  id: number;
  nis: string;
  name: string;
  grade: string;
  major: string;
  room: string;
}

interface Service {
  id: number;
  name: string;
  parent_id: number | null;
}

interface CounselingRecord {
  id: number;
  date: string;
  activity: string;
  location: string;
  description: string;
  notes: string;
  student_id: number;
  service_id: number;
  student_name: string;
  service_name: string;
  user_name: string;
}

const CounselingRecords: React.FC = () => {
  const [records, setRecords] = useState<CounselingRecord[]>([]);
  const [students, setStudents] = useState<Student[]>([]);
  const [services, setServices] = useState<Service[]>([]);
  const [loading, setLoading] = useState(true);
  const [searchTerm, setSearchTerm] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [viewingRecord, setViewingRecord] = useState<CounselingRecord | null>(null);
  const [editingRecord, setEditingRecord] = useState<CounselingRecord | null>(null);
  const [formData, setFormData] = useState({
    date: '',
    activity: '',
    location: '',
    description: '',
    notes: '',
    student_id: '',
    service_id: '',
  });

  useEffect(() => {
    fetchData();
  }, [searchTerm]);

  const fetchData = async () => {
    try {
      const [recordsRes, studentsRes, servicesRes] = await Promise.all([
        axios.get(`/api/counseling-records${searchTerm ? `?search=${searchTerm}` : ''}`),
        axios.get('/api/students'),
        axios.get('/api/services'),
      ]);
      
      setRecords(recordsRes.data);
      setStudents(studentsRes.data);
      setServices(servicesRes.data);
    } catch (error) {
      toast.error('Gagal memuat data');
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      const data = {
        ...formData,
        student_id: parseInt(formData.student_id),
        service_id: parseInt(formData.service_id),
      };

      if (editingRecord) {
        await axios.put(`/api/counseling-records/${editingRecord.id}`, data);
        toast.success('Rekaman berhasil diperbarui');
      } else {
        await axios.post('/api/counseling-records', data);
        toast.success('Rekaman berhasil ditambahkan');
      }
      
      setShowModal(false);
      setEditingRecord(null);
      resetForm();
      fetchData();
    } catch (error: any) {
      const message = error.response?.data?.error || 'Terjadi kesalahan';
      toast.error(message);
    }
  };

  const handleEdit = (record: CounselingRecord) => {
    setEditingRecord(record);
    setFormData({
      date: record.date,
      activity: record.activity,
      location: record.location,
      description: record.description,
      notes: record.notes,
      student_id: record.student_id.toString(),
      service_id: record.service_id.toString(),
    });
    setShowModal(true);
  };

  const handleDelete = async (id: number) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus rekaman ini?')) {
      try {
        await axios.delete(`/api/counseling-records/${id}`);
        toast.success('Rekaman berhasil dihapus');
        fetchData();
      } catch (error) {
        toast.error('Gagal menghapus rekaman');
      }
    }
  };

  const handlePrint = (record: CounselingRecord) => {
    const printWindow = window.open('', '_blank');
    if (printWindow) {
      printWindow.document.write(`
        <html>
          <head>
            <title>Rekaman Konseling - ${record.student_name}</title>
            <style>
              body { font-family: Arial, sans-serif; margin: 20px; }
              .header { text-align: center; margin-bottom: 30px; }
              .record { margin-bottom: 20px; }
              .field { margin-bottom: 10px; }
              .label { font-weight: bold; }
              .value { margin-left: 10px; }
              table { width: 100%; border-collapse: collapse; margin-top: 20px; }
              th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
              th { background-color: #f2f2f2; }
              @media print { body { margin: 0; } }
            </style>
          </head>
          <body>
            <div class="header">
              <h1>REKAMAN KEGIATAN KONSELING</h1>
              <h2>Arsip Bimbingan Konseling</h2>
            </div>
            <div class="record">
              <div class="field">
                <span class="label">Tanggal:</span>
                <span class="value">${new Date(record.date).toLocaleDateString('id-ID')}</span>
              </div>
              <div class="field">
                <span class="label">Nama Siswa:</span>
                <span class="value">${record.student_name}</span>
              </div>
              <div class="field">
                <span class="label">Kegiatan:</span>
                <span class="value">${record.activity}</span>
              </div>
              <div class="field">
                <span class="label">Tempat:</span>
                <span class="value">${record.location}</span>
              </div>
              <div class="field">
                <span class="label">Layanan:</span>
                <span class="value">${record.service_name}</span>
              </div>
              <div class="field">
                <span class="label">Uraian:</span>
                <span class="value">${record.description || '-'}</span>
              </div>
              <div class="field">
                <span class="label">Keterangan:</span>
                <span class="value">${record.notes || '-'}</span>
              </div>
              <div class="field">
                <span class="label">Konselor:</span>
                <span class="value">${record.user_name}</span>
              </div>
            </div>
          </body>
        </html>
      `);
      printWindow.document.close();
      printWindow.print();
    }
  };

  const resetForm = () => {
    setFormData({
      date: '',
      activity: '',
      location: '',
      description: '',
      notes: '',
      student_id: '',
      service_id: '',
    });
  };

  const openAddModal = () => {
    setEditingRecord(null);
    resetForm();
    setShowModal(true);
  };

  const getParentServices = () => {
    return services.filter(service => !service.parent_id);
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
      <div className="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
          <h1 className="text-2xl font-bold text-gray-900">Rekaman Konseling</h1>
          <p className="text-gray-600">Kelola rekaman kegiatan konseling</p>
        </div>
        <button
          onClick={openAddModal}
          className="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
        >
          <Plus className="h-4 w-4 mr-2" />
          Tambah Rekaman
        </button>
      </div>

      {/* Search */}
      <div className="mb-6">
        <div className="relative">
          <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <Search className="h-5 w-5 text-gray-400" />
          </div>
          <input
            type="text"
            placeholder="Cari rekaman berdasarkan nama siswa, kegiatan, atau uraian..."
            className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
        </div>
      </div>

      {/* Records Table */}
      <div className="bg-white shadow overflow-hidden sm:rounded-md">
        <table className="min-w-full divide-y divide-gray-200">
          <thead className="bg-gray-50">
            <tr>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tanggal
              </th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Siswa
              </th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Kegiatan
              </th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Tempat
              </th>
              <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Layanan
              </th>
              <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Aksi
              </th>
            </tr>
          </thead>
          <tbody className="bg-white divide-y divide-gray-200">
            {records.map((record) => (
              <tr key={record.id}>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {new Date(record.date).toLocaleDateString('id-ID')}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {record.student_name}
                </td>
                <td className="px-6 py-4 text-sm text-gray-900">
                  <div className="max-w-xs truncate" title={record.activity}>
                    {record.activity}
                  </div>
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {record.location}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {record.service_name}
                </td>
                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <div className="flex justify-end space-x-2">
                    <button
                      onClick={() => setViewingRecord(record)}
                      className="text-primary-600 hover:text-primary-900"
                      title="Lihat Detail"
                    >
                      <Eye className="h-4 w-4" />
                    </button>
                    <button
                      onClick={() => handlePrint(record)}
                      className="text-green-600 hover:text-green-900"
                      title="Cetak"
                    >
                      <Printer className="h-4 w-4" />
                    </button>
                    <button
                      onClick={() => handleEdit(record)}
                      className="text-indigo-600 hover:text-indigo-900"
                      title="Edit"
                    >
                      <Edit className="h-4 w-4" />
                    </button>
                    <button
                      onClick={() => handleDelete(record.id)}
                      className="text-red-600 hover:text-red-900"
                      title="Hapus"
                    >
                      <Trash2 className="h-4 w-4" />
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        {records.length === 0 && (
          <div className="text-center py-12">
            <p className="text-gray-500">Tidak ada rekaman konseling</p>
          </div>
        )}
      </div>

      {/* Add/Edit Modal */}
      {showModal && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div className="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div className="mt-3">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-medium text-gray-900">
                  {editingRecord ? 'Edit Rekaman' : 'Tambah Rekaman'}
                </h3>
                <button
                  onClick={() => setShowModal(false)}
                  className="text-gray-400 hover:text-gray-600"
                >
                  <X className="h-6 w-6" />
                </button>
              </div>
              <form onSubmit={handleSubmit} className="space-y-4">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input
                      type="date"
                      required
                      className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                      value={formData.date}
                      onChange={(e) => setFormData({ ...formData, date: e.target.value })}
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700">Siswa</label>
                    <select
                      required
                      className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                      value={formData.student_id}
                      onChange={(e) => setFormData({ ...formData, student_id: e.target.value })}
                    >
                      <option value="">Pilih siswa</option>
                      {students.map((student) => (
                        <option key={student.id} value={student.id}>
                          {student.name} - {student.nis}
                        </option>
                      ))}
                    </select>
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Kegiatan</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.activity}
                    onChange={(e) => setFormData({ ...formData, activity: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Tempat</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.location}
                    onChange={(e) => setFormData({ ...formData, location: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Layanan</label>
                  <select
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.service_id}
                    onChange={(e) => setFormData({ ...formData, service_id: e.target.value })}
                  >
                    <option value="">Pilih layanan</option>
                    {getParentServices().map((service) => (
                      <option key={service.id} value={service.id}>
                        {service.name}
                      </option>
                    ))}
                  </select>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Uraian</label>
                  <textarea
                    rows={3}
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.description}
                    onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Keterangan</label>
                  <textarea
                    rows={3}
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.notes}
                    onChange={(e) => setFormData({ ...formData, notes: e.target.value })}
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
                    {editingRecord ? 'Update' : 'Simpan'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}

      {/* View Modal */}
      {viewingRecord && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div className="relative top-10 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div className="mt-3">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-medium text-gray-900">Detail Rekaman</h3>
                <button
                  onClick={() => setViewingRecord(null)}
                  className="text-gray-400 hover:text-gray-600"
                >
                  <X className="h-6 w-6" />
                </button>
              </div>
              <div className="space-y-4">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700">Tanggal</label>
                    <p className="mt-1 text-sm text-gray-900">
                      {new Date(viewingRecord.date).toLocaleDateString('id-ID')}
                    </p>
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700">Siswa</label>
                    <p className="mt-1 text-sm text-gray-900">{viewingRecord.student_name}</p>
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Kegiatan</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingRecord.activity}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Tempat</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingRecord.location}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Layanan</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingRecord.service_name}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Uraian</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingRecord.description || '-'}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Keterangan</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingRecord.notes || '-'}</p>
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Konselor</label>
                  <p className="mt-1 text-sm text-gray-900">{viewingRecord.user_name}</p>
                </div>
                <div className="flex justify-end space-x-3 pt-4">
                  <button
                    onClick={() => handlePrint(viewingRecord)}
                    className="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700"
                  >
                    <Printer className="h-4 w-4 mr-2 inline" />
                    Cetak
                  </button>
                  <button
                    onClick={() => setViewingRecord(null)}
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

export default CounselingRecords; 
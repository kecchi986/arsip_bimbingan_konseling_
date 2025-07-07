import React, { useState, useEffect } from 'react';
import axios from 'axios';
import toast from 'react-hot-toast';
import { Plus, Edit, Trash2, X } from 'lucide-react';

interface Service {
  id: number;
  name: string;
  parent_id: number | null;
  parent_name?: string;
}

const Services: React.FC = () => {
  const [services, setServices] = useState<Service[]>([]);
  const [loading, setLoading] = useState(true);
  const [showModal, setShowModal] = useState(false);
  const [editingService, setEditingService] = useState<Service | null>(null);
  const [formData, setFormData] = useState({
    name: '',
    parent_id: '',
  });

  useEffect(() => {
    fetchServices();
  }, []);

  const fetchServices = async () => {
    try {
      const response = await axios.get('/api/services');
      setServices(response.data);
    } catch (error) {
      toast.error('Gagal memuat data layanan');
    } finally {
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    
    try {
      const data = {
        name: formData.name,
        parent_id: formData.parent_id !== '' ? parseInt(formData.parent_id) : null,
      };

      if (editingService) {
        await axios.put(`/api/services/${editingService.id}`, data);
        toast.success('Layanan berhasil diperbarui');
      } else {
        await axios.post('/api/services', data);
        toast.success('Layanan berhasil ditambahkan');
      }
      
      setShowModal(false);
      setEditingService(null);
      resetForm();
      fetchServices();
    } catch (error: any) {
      const message = error.response?.data?.error || 'Terjadi kesalahan';
      toast.error(message);
    }
  };

  const handleEdit = (service: Service) => {
    setEditingService(service);
    setFormData({
      name: service.name,
      parent_id: service.parent_id?.toString() || '',
    });
    setShowModal(true);
  };

  const handleDelete = async (id: number) => {
    if (window.confirm('Apakah Anda yakin ingin menghapus layanan ini?')) {
      try {
        await axios.delete(`/api/services/${id}`);
        toast.success('Layanan berhasil dihapus');
        fetchServices();
      } catch (error) {
        toast.error('Gagal menghapus layanan');
      }
    }
  };

  const resetForm = () => {
    setFormData({
      name: '',
      parent_id: '',
    });
  };

  const openAddModal = () => {
    setEditingService(null);
    resetForm();
    setShowModal(true);
  };

  const getParentServices = () => {
    return services.filter(service => service.parent_id === null);
  };

  const getSubServices = (parentId: number) => {
    return services.filter(service => service.parent_id === parentId);
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
      {/* Header & Tambah Layanan */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
        <h1 className="text-xl font-bold mb-2 sm:mb-0">Layanan</h1>
        <button
          onClick={openAddModal}
          className="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow flex items-center"
        >
          <Plus className="h-5 w-5 mr-2" /> Tambah Layanan
        </button>
      </div>

      {/* Services List */}
      <div className="bg-white shadow rounded p-6">
        {/* LAYANAN DASAR */}
        <div className="mb-6">
          <div className="font-bold text-gray-700 mb-2">LAYANAN DASAR</div>
          {getParentServices().map((parentService) => (
            <div key={parentService.id} className="mb-2 border rounded p-3 bg-gray-50">
              <div className="flex items-center justify-between">
                <div className="font-semibold">{parentService.name}</div>
                <div className="flex space-x-2">
                  <button
                    onClick={() => handleEdit(parentService)}
                    className="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs mr-1"
                  >
                    Edit
                  </button>
                  <button
                    onClick={() => handleDelete(parentService.id)}
                    className="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs"
                  >
                    Delete
                  </button>
                </div>
              </div>
              {/* Sub Services */}
              {getSubServices(parentService.id).length > 0 && (
                <div className="ml-4 mt-2">
                  {getSubServices(parentService.id).map((subService) => (
                    <div key={subService.id} className="flex items-center justify-between border rounded p-2 mb-1 bg-white">
                      <div className="text-sm">{subService.name}</div>
                      <div className="flex space-x-2">
                        <button
                          onClick={() => handleEdit(subService)}
                          className="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs mr-1"
                        >
                          Edit
                        </button>
                        <button
                          onClick={() => handleDelete(subService.id)}
                          className="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  ))}
                </div>
              )}
            </div>
          ))}
        </div>
        {/* LAYANAN RESPONSIF (dummy, bisa disesuaikan filter/label sesuai kebutuhan) */}
        {/* <div className="mb-6">
          <div className="font-bold text-gray-700 mb-2">LAYANAN RESPONSIF</div>
          ...
        </div> */}
        {getParentServices().length === 0 && (
          <p className="text-gray-500 text-center py-8">
            Belum ada layanan yang ditambahkan
          </p>
        )}
      </div>

      {/* Add/Edit Modal */}
      {showModal && (
        <div className="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
          <div className="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div className="mt-3">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-lg font-medium text-gray-900">
                  {editingService ? 'Edit Layanan' : 'Tambah Layanan'}
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
                  <label className="block text-sm font-medium text-gray-700">Nama Layanan</label>
                  <input
                    type="text"
                    required
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.name}
                    onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700">Layanan Induk (Opsional)</label>
                  <select
                    className="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    value={formData.parent_id}
                    onChange={(e) => setFormData({ ...formData, parent_id: e.target.value })}
                  >
                    <option value="">Pilih layanan induk (untuk sub layanan)</option>
                    {getParentServices()
                      .filter(service => !editingService || service.id !== editingService.id)
                      .map((service) => (
                        <option key={service.id} value={service.id}>
                          {service.name}
                        </option>
                      ))}
                  </select>
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
                    {editingService ? 'Update' : 'Simpan'}
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default Services; 
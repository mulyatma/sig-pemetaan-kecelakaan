# 🚦 GIS Accident Mapping with K-Means Clustering

This project is a **Geographic Information System (GIS) for Accident Mapping** that uses the **K-Means Clustering** method to group accident points based on location and severity.  

The project is built with:
- **Laravel** as the backend framework  
- **MySQL** as the database  
- **Admin Stisla Template** for dashboard UI  
- **Leaflet.js** for interactive maps  

---

## ✨ Key Features
- 📍 Accident location mapping using coordinates (latitude & longitude)  
- 📊 Accident data clustering with **K-Means**  
- 🗺️ Interactive map visualization with **Leaflet**  
- 📑 Accident Data CRUD (create, read, update, delete, view details)  
- 📈 Cluster analysis displayed on maps and tables
  
---

## 📊 K-Means Method
The **K-Means** method is used to cluster accident data based on coordinates and severity.  
Main steps:
1. Define the number of clusters (k)  
2. Set initial centroids  
3. Calculate the distance of each point to centroids  
4. Assign each point to the nearest cluster  
5. Update centroids until convergence  

The clustering results are visualized on an interactive map.

---

## 🌍 Indonesian Regional Data
To display administrative boundaries of Indonesia (provinces, districts/cities, sub-districts) in **GeoJSON** format, this project uses the following reference:  

📌 [indonesia-district (by JfrAziz)](https://github.com/JfrAziz/indonesia-district)  

This repository provides GeoJSON data that can be directly used with **Leaflet.js** for Indonesian region map overlays.  

---

## 💡 Technologies Used
- **Laravel 12**  
- **MySQL**  
- **Admin Stisla Template**  
- **Leaflet.js**  
- **K-Means Algorithm (PHP Implementation)**  


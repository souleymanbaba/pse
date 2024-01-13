import pandas as pd
import numpy as np
from sklearn.discriminant_analysis import LinearDiscriminantAnalysis
import matplotlib.pyplot as plt
import matplotlib.image as img

# Lecture et traitement des données
df = pd.read_excel('chiffres.xlsx')
XY = df.values
n = XY.shape[0]
p = XY.shape[1]-1
X = XY[:,0:p]
Y = XY[:,p]
t = 1800
XY_train = XY[0:t,:]
XY_test = XY[t:n,:]
X_train = XY_train[:,0:p]
X_test = XY_test[:,0:p]
Y_train = XY_train[:,p]
Y_test = XY_test[:,p]
lda = LinearDiscriminantAnalysis()
lda.fit(X_train,Y_train)
print('Les classens sont : ')
print(lda.classes_)
classement = lda.predict(X_train)
taux = np.sum(Y_train==classement)/t
print("Réussite sur le training set : {} ".format(taux))

classement = lda.predict(X_test)
print('Réussite sur le test set : ',np.sum(Y_test==classement)/(n-t))

# Viualisation du nuage des points sur le premier plan discriminant
F = lda.transform(X_train)
U = lda.scalings_
Moyennes = lda.means_
Moyennes_projetees = np.dot(Moyennes,U)
Coul_code = ['#F0C0FA','c','#FAF785','y','#F1B909','#FA859C','#85B7FA','#D0E2AF','#0BF4F7','#85FA85']
Coul_classe = dict()
m=10
for k in range(m):
    Coul_classe[lda.classes_[k]] = Coul_code[k]
coul_ind = []
for i in range(t):
      coul_ind.append(Coul_classe[Y_train[i]])
fig, ax = plt.subplots()
ax.scatter(F[:,0] ,F[:,1], color = coul_ind)
ax.set_title('Projection des individus sur le premier plan discriminant')
ax.set_xlabel('1er axe discriminant')
ax.set_ylabel('2ème axe discriminant')
Nom = [5,2,8,9,4,7,6,3,1,0]
for k in range(m):
    ax.annotate(str(Nom[k]), (Moyennes_projetees[k,0] ,Moyennes_projetees[k,1]), fontsize=20, c='k')
plt.show()

A = img.imread('six.png')
print(A.shape)
n = A.shape[0]
m = A.shape[1]
V = np.zeros(n*m)
for i in range(n):
    for j in range(m):
        V[m*i +j] = int(A[i][j][0]*255)
V = V.reshape(1,n*m)

new = lda.predict(V)
print('Ce chiffre est un : ', new)

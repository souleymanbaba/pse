from ortools.linear_solver import pywraplp

# Données du problème
weights = [5, 4, 3, 2, 9, 6, 8, 1, 4, 7]
quantities = [15, 52, 39, 18, 45, 27, 12, 12, 14, 31]
bin_capacity = 100
max_bins = 20

# Création du solveur
solver = pywraplp.Solver.CreateSolver('SCIP')

x = {}
for i in range(len(weights)):
    for j in range(max_bins):
        x[i, j] = solver.IntVar(0, solver.infinity(), 'x[%i,%i]' % (i, j))
y = {}
for j in range(max_bins):
    y[j] = solver.IntVar(0, 1, 'y[%i]' % j)

# Contraintes
# Chaque objet doit être complètement assigné à des bins
for i in range(len(weights)):
    solver.Add(sum(x[i, j] for j in range(max_bins)) == quantities[i])

# La capacité des bins ne doit pas être dépassée
for j in range(max_bins):
    solver.Add(sum(x[i, j] * weights[i] for i in range(len(weights))) <= y[j] * bin_capacity)

# Fonction objectif: Minimiser le nombre de bins utilisés
objective = solver.Objective()
for j in range(max_bins):
    objective.SetCoefficient(y[j], 1)
objective.SetMinimization()

# Résolution
status = solver.Solve()

# Affichage des résultats
if status == pywraplp.Solver.OPTIMAL:
    print('Solution trouvée !')
    print('Nombre total de bins utilisés:', sum(y[j].solution_value() for j in range(max_bins)))
    for j in range(max_bins):
        if y[j].solution_value() > 0:
            print('\nBin numéro', j)
            print('Objets placés dans ce bin:')
            for i in range(len(weights)):
                if x[i, j].solution_value() > 0:
                    print(f'Objet {i+1} - Quantité: {x[i, j].solution_value()}')
else:
    print('Pas de solution optimale trouvée.')

# from ortools.linear_solver import pywraplp
#
# # Données du problème
# weights = [5, 4, 3, 2, 9, 6, 8, 1, 4, 7]
# quantities = [15, 52, 39, 18, 45, 27, 12, 12, 14, 31]
# bin_capacity = 100
# max_bins = 20
#
# # Création du solveur
# solver = pywraplp.Solver.CreateSolver('SCIP')
#
# # Variables
# # x[i][j] est le nombre d'objets de type i placés dans le bin j
# x = {}
# for i in range(len(weights)):
#     for j in range(max_bins):
#         x[i, j] = solver.IntVar(0, solver.infinity(), 'x[%i,%i]' % (i, j))
#
# # y[j] est une variable binaire qui est 1 si le bin j est utilisé
# y = {}
# for j in range(max_bins):
#     y[j] = solver.IntVar(0, 1, 'y[%i]' % j)
#
# # Contraintes
# # Chaque objet doit être complètement assigné à des bins
#
# for i in range(len(weights)):
#     constraint = solver.Constraint(quantities[i], quantities[i])
#     for j in range(max_bins):
#         constraint.SetCoefficient(x[i, j], 1)
#
# # La capacité des bins ne doit pas être dépassée
# for j in range(max_bins):
#     constraint = solver.Constraint(0, bin_capacity)
#     for i in range(len(weights)):
#         constraint.SetCoefficient(x[i, j], weights[i])
#     constraint.SetCoefficient(y[j], -bin_capacity)
#
# # Fonction objectif: Minimiser le nombre de bins utilisés
# objective = solver.Objective()
# for j in range(max_bins):
#     objective.SetCoefficient(y[j], 1)
# objective.SetMinimization()
#
# # Résolution
# status = solver.Solve()
#
# # Affichage des résultats
# if status == pywraplp.Solver.OPTIMAL:
#     print('Solution trouvée !')
#     print('Nombre total de bins utilisés:', sum(y[j].solution_value() for j in range(max_bins)))
#     for j in range(max_bins):
#         if y[j].solution_value() > 0:
#             print('\nBin numéro', j)
#             print('Objets placés dans ce bin:')
#             for i in range(len(weights)):
#                 if x[i, j].solution_value() > 0:
#                     print(f'Objet {i+1} - Quantité: {x[i, j].solution_value()}')
# else:
#     print('Pas de solution optimale trouvée.')
